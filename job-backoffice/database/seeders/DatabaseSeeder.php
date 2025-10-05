<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\Resume;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the root admin
        User::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Admin',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Load the job data
        $path = database_path('data/job_data.json');
        $jobData = json_decode(file_get_contents($path), true);

        // ##### Create Job Categories #####
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate(['name' => $category]);
        }

        // ##### Create Companies #####
        foreach ($jobData['companies'] as $company) {
            // Create the company owner
            $owner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => $company['name'],
                'password' => Hash::make('12345678'),
                    'role' => 'company_owner',
                'email_verified_at' => now(),
            ]);

            // Create the company
            Company::firstOrCreate(['name' => $company['name']], [
                'ownerId' => $owner->id,
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website']
            ]);
        }

        // ##### Create Job Vacancies #####
        foreach ($jobData['jobVacancies'] as $job) {
            // Fetch the company using name
            $company = Company::where('name', $job['company'])->first();

            // Fetch the job category using name
            $jobCategory = JobCategory::where('name', $job['category'])->first();

            JobVacancy::firstOrCreate([
                'title' => $job['title'],
                'companyId' => $company->id,
                'jobCategoryId' => $jobCategory->id,
            ], [
                'description' => $job['description'],
                'location' => $job['location'],
                'type' => $job['type'],
                'salary' => $job['salary'],
            ]);
        }

        // Load the job applications data
        $path = database_path('data/job_applications.json');
        $jobApplicationsData = json_decode(file_get_contents($path), true);

        // ##### Create Job Applications #####
        foreach ($jobApplicationsData['jobApplications'] as $application) {
            // Create teh job-seeker applicant
            $applicant = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'job_seeker',
                'email_verified_at' => now(),
            ]);

            // Create the resume first
            $resume = Resume::firstOrCreate([
                'userId' => $applicant->id,
                'fileName' => $application['resume']['filename'],
                'fileUrl' => $application['resume']['fileUri'],
            ], [
                'contactDetails' => $application['resume']['contactDetails'],
                'summary' => $application['resume']['summary'],
                'skills' => $application['resume']['skills'],
                'experience' => $application['resume']['experience'],
                'education' => $application['resume']['education'],
            ]);

            // Randomly select a job vacancy
            $jobVacancy = JobVacancy::inRandomOrder()->first();

            JobApplication::firstOrCreate([
                'userId' => $applicant->id,
                'resumeId' => $resume->id,
                'jobVacancyId' => $jobVacancy->id,   
            ], [
                'status' => $application['status'],
                'aiGeneratedScore' => $application['aiGeneratedScore'],
                'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
            ]);
        }
    }
}