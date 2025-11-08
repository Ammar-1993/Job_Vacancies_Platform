<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Resume;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use OpenAI\Laravel\Facades\OpenAI;

use App\Http\Requests\ApplyJobRequest;
use App\Services\ResumeAnalysisService;
class JobVacancyController extends Controller
{
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $resumes = auth()->user()->resumes;
        return view('job-vacancies.apply', compact('jobVacancy', 'resumes'));
    }

    public function processApplication(ApplyJobRequest $request, string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $resumeId = null;
        $extractedInfo = null;

        if ($request->input('resume_option') === 'new_resume') {
            $file = $request->file('resume_file');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = $file->getClientOriginalName();
            $fileName = 'resume_' . time() . '.' . $extension;

            // Store in laravel cloud
            $path = $file->storeAs('resumes', $fileName, 'cloud');

            $fileUrl = config('filesystems.disks.cloud.url') . '/' . $path;

            $extractedInfo = $this->resumeAnalysisService->extractResumeInformation($fileUrl);

            $resume = Resume::create([
                'filename' => $originalFileName,
                'fileUri' => $path,
                'userId' => auth()->id(),
                'contactDetails' => json_encode([
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ]),
                'summary' => $extractedInfo['summary'],
                'skills' => $extractedInfo['skills'],
                'experience' => $extractedInfo['experience'],
                'education' => $extractedInfo['education']
            ]);

            $resumeId = $resume->id;

          
        } else {
            $resumeId = $request->input('resume_option');
            $resume = Resume::findOrFail($resumeId);

            $extractedInfo = [
                'summary' => $resume->summary,
                'skills' => $resume->skills,
                'experience' => $resume->experience,
                'education' => $resume->education
            ];
        }

        // Evalute Job Application
        $evaluation = $this->resumeAnalysisService->analyzeResume($jobVacancy, $extractedInfo);

        JobApplication::create([
            'status' => 'pending',
            'jobVacancyId' => $id,
            'resumeId' => $resumeId,
            'userId' => auth()->id(),
            'aiGeneratedScore' => $evaluation['aiGeneratedScore'],
            'aiGeneratedFeedback' => $evaluation['aiGeneratedFeedback'],
        ]);
        
        return redirect()->route('job-applications.index', $id)->with('success', 'Application submitted successfully');
    }

    public function testOpenAI()
    {
        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => 'Say hello in JSON like {"hello":"world"}'
                    ]
                ]
            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

 
}