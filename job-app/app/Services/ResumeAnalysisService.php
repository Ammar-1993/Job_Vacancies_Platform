<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisService
{
    public function extractResumeInformation(string $fileUrl)
    {
        try {
            // Extract raw text from the resume pdf file (read pdf file, and get the text)
            $rawText = $this->extractTextFromPdf($fileUrl);

            Log::debug('Successfully extracted text from pdf file' . strlen($rawText) . ' characters');

            // Use OpenAI API to organize the text into a structured format
                $response = $this->callOpenAiWithRetriesAndFallback([
                    // model will be set by the fallback caller
                'messages' => [
                    [
                        'role' => 'system',
                            'content' => 'You are a precise resume parser. Extract information exactly as it appears in the resume without adding any interpretation or additional information. The output should be in JSON format.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "Parse the following resume content and extract the information as a JSON Object with the exact keys: 'summary', 'skills', 'experience', 'education'. The resume content is: {$rawText}. Return an empty string for key that if not found."
                    ]
                ],
                'response_format' => [
                    'type' => 'json_object'
                ],
                'temperature' => 0.1  // Sets the randomness of the AI response to 0, making it deterministic and focused on the most likely completion
                ], ['gpt-4o', 'gpt-4', 'gpt-3.5-turbo']);

            $result = $response->choices[0]->message->content;
            Log::debug('OpenAI response: ' . $result);

            $parsedResult = $this->extractFirstJson($result);

            if ($parsedResult === null) {
                Log::error('Failed to parse OpenAI response: unable to find valid JSON in response');
                throw new \Exception('Failed to parse OpenAI response');
            }

            // Validate the parsed result
            $requiredKeys = ['summary', 'skills', 'experience', 'education'];
            $missingKeys = array_diff($requiredKeys, array_keys($parsedResult));

            if (count($missingKeys) > 0) {
                Log::error('Missing required keys: ' . implode(', ', $missingKeys));
                throw new \Exception('Missing required keys in the parsed result');
            }

            // Return the JSON object
            return [
                'summary' => $parsedResult['summary'] ?? '',
                'skills' => $parsedResult['skills'] ?? '',
                'experience' => $parsedResult['experience'] ?? '',
                'education' => $parsedResult['education'] ?? ''
            ];
        } catch (\Exception $e) {
            Log::error('Error extracting resume information: ' . $e->getMessage() . ' | trace: ' . $e->getTraceAsString());
            return [
                'summary' => '',
                'skills' => '',
                'experience' => '',
                'education' => ''
            ];
        }
    }

    public function analyzeResume($jobVacancy, $resumeData) {
        try { 
            $jobDetails = json_encode([
                'job_title' => $jobVacancy->title,
                'job_description' => $jobVacancy->description,
                'job_location' => $jobVacancy->location,
                'job_type' => $jobVacancy->type,
                'job_salary' => $jobVacancy->salary,
            ]);

            $resumeDetails = json_encode($resumeData);

            $response = $this->callOpenAiWithRetriesAndFallback([
                // model will be set by the fallback caller
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are an expert HR professional and job recruiter. You are given a job vacancy and a resume. 
                                      Your task is to analyze the resume and determine if the candidate is a good fit for the job. 
                                      The output should be in JSON format.
                                      Provide a score from 0 to 100 for the candidate's suitability for the job, and a detailed feedback.
                                      Response should only be Json that has the following keys: 'aiGeneratedScore', 'aiGeneratedFeedback'.
                                      Aigenerate feedback should be detailed and specific to the job and the candidate's resume."
                    ],
                    [   
                        'role' => 'user',
                        'content' => "Please evalute this job application. Job Details: {$jobDetails}. Resume Details: {$resumeDetails}"
                    ]
                ],
                'response_format' => [
                    'type' => 'json_object'
                ],
                'temperature' => 0.1
            ], ['gpt-4o', 'gpt-4', 'gpt-3.5-turbo']);

            $result = $response->choices[0]->message->content;
            Log::debug('OpenAI evaluationresponse: ' . $result);

            $parsedResult = $this->extractFirstJson($result);

            if ($parsedResult === null) {
                Log::error('Failed to parse OpenAI response: unable to find valid JSON in response');
                throw new \Exception('Failed to parse OpenAI response');
            }

            if(!isset($parsedResult['aiGeneratedScore']) || !isset($parsedResult['aiGeneratedFeedback'])) {
                Log::error('Missing required keys in the parsed result');
                throw new \Exception('Missing required keys in the parsed result');
            }

            return $parsedResult;
   
        } catch (\Exception $e) {
            Log::error('Error analyzing resume: ' . $e->getMessage());
            return [
                'aiGeneratedScore' => 0,
                'aiGeneratedFeedback' => 'An error occurred while analyzing the resume. Please try again later.'
            ];
        }
    }


    private function extractTextFromPdf(string $fileUrl): string
    {
        // Reading the file from the cloud to local disk storage in temp file
        $tempFile = tempnam(sys_get_temp_dir(), 'resume');

        $filePath = parse_url($fileUrl, PHP_URL_PATH);
        if (!$filePath) {
            throw new \Exception('Invalid file URL');
        }

        $filename = basename($filePath);

        $storagePath = "resumes/{$filename}";

        if (!Storage::disk('cloud')->exists($storagePath)) {
            throw new \Exception('File not found');
        }

        $pdfContent = Storage::disk('cloud')->get($storagePath);
        if (!$pdfContent) {
            throw new \Exception('Failed to read file');
        }

        file_put_contents($tempFile, $pdfContent);

        // Check if pdf-to-text is installed
        $pdfToTextPath = ['/opt/homebrew/bin/pdftotext', '/usr/bin/pdftotext', '/usr/local/bin/pdftotext'];
        $pdfToTextAvailable = false;

        foreach ($pdfToTextPath as $path) {
            if (file_exists($path)) {
                $pdfToTextAvailable = true;
                break;
            }
        }

        if (!$pdfToTextAvailable) {
            throw new \Exception('pdf-to-text is not installed');
        }

        // Extract text from the pdf file
        $instance = new Pdf();
        $instance->setPdf($tempFile);
        $text = $instance->text();

        // Clean up the temp file
        unlink($tempFile);

        return $text;
    }

    /**
     * Call OpenAI chat.create with retries on rate limit or temporary failures.
     * Returns the response object on success or throws the last exception on failure.
     */
    private function callOpenAiWithRetries(array $payload)
    {
        $maxAttempts = 3;
        $attempt = 0;
        $backoffSeconds = 1;

        while ($attempt < $maxAttempts) {
            try {
                return OpenAI::chat()->create($payload);
            } catch (\Throwable $e) {
                $attempt++;

                $message = strtolower($e->getMessage() ?? '');
                $code = (int) $e->getCode();

                $isRateLimit = ($code === 429) || str_contains($message, 'rate limit') || str_contains($message, 'too many requests');

                Log::warning("OpenAI request failed (attempt {$attempt}/{$maxAttempts}) - code: {$code}, message: {$e->getMessage()}");

                if ($attempt >= $maxAttempts || ! $isRateLimit) {
                    throw $e;
                }

                // jittered backoff: base seconds + random milliseconds
                $jitterMs = rand(0, 500);
                $sleepMicro = ($backoffSeconds * 1000000) + ($jitterMs * 1000);
                usleep($sleepMicro);
                $backoffSeconds *= 2;
            }
        }

        throw new \RuntimeException('OpenAI request failed after retries');
    }

    /**
     * Try a list of models as fallback. For each model, call the retrying requester.
     */
    private function callOpenAiWithRetriesAndFallback(array $payload, array $models)
    {
        $lastException = null;

        foreach ($models as $model) {
            $payload['model'] = $model;
            try {
                Log::info("Trying OpenAI model: {$model}");
                return $this->callOpenAiWithRetries($payload);
            } catch (\Throwable $e) {
                $lastException = $e;
                $msg = strtolower($e->getMessage() ?? '');
                $code = (int) $e->getCode();

                $isRateLimit = ($code === 429) || str_contains($msg, 'rate limit') || str_contains($msg, 'too many requests');
                $isModelNotFound = str_contains($msg, 'model') && (str_contains($msg, 'not found') || str_contains($msg, 'does not exist') || str_contains($msg, 'is not available') || str_contains($msg, 'unknown model'));

                Log::warning("Model {$model} failed: {$e->getMessage()}");

                if ($isModelNotFound) {
                    // try next model immediately
                    continue;
                }

                if ($isRateLimit) {
                    // wait a little before trying the next model
                    sleep(1);
                    continue;
                }

                // for other errors, break and rethrow after loop
                break;
            }
        }

        if ($lastException) {
            throw $lastException;
        }

        throw new \RuntimeException('OpenAI request failed using all fallback models');
    }

    /**
     * Extract the first JSON object or array found in a string.
     * Returns associative array on success or null on failure.
     */
    private function extractFirstJson(string $text): ?array
    {
        $start = null;
        $stack = [];
        $len = strlen($text);

        for ($i = 0; $i < $len; $i++) {
            $char = $text[$i];
            if ($char === '{' || $char === '[') {
                if (empty($stack)) {
                    $start = $i;
                }
                $stack[] = $char;
            } elseif ($char === '}' || $char === ']') {
                if (empty($stack)) {
                    continue;
                }
                $last = array_pop($stack);
                if (($last === '{' && $char !== '}') || ($last === '[' && $char !== ']')) {
                    $stack = [];
                    $start = null;
                    continue;
                }
                if (empty($stack) && $start !== null) {
                    $jsonText = substr($text, $start, $i - $start + 1);
                    $decoded = json_decode($jsonText, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        return $decoded;
                    }
                    $start = null;
                }
            }
        }

        $decoded = json_decode($text, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return null;
    }
}