<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'admin'){
            $analytics = $this->adminDashboard();
        } else {
            $analytics = $this->companyOwnerDashboard();
        }

        return view('dashboard.index', compact(['analytics']));
    }

    private function adminDashboard()
    {
        // Last 30 days active users (job_seeker role)
        $activeUsers = Cache::remember('admin_active_users', 600, function () {
            return User::where('last_login_at', '>=', now()->subDays(30))
                ->where('role', 'job_seeker')->count();
        });

        // Total jobs (not deleted)
        $totalJobs = Cache::remember('admin_total_jobs', 600, function () {
            return JobVacancy::whereNull('deleted_at')->count();
        });

        // Total applications (not deleted)
        $totalApplications = Cache::remember('admin_total_applications', 600, function () {
            return JobApplication::whereNull('deleted_at')->count();
        });

        // Most applied jobs
        $mostAppliedJobs = Cache::remember('admin_most_applied_jobs', 600, function () {
            return JobVacancy::with(['company' => function($q) { $q->withTrashed(); }])->withCount('jobApplications as totalCount')
                ->whereNull('deleted_at')
                ->limit(5)
                ->orderByDesc('totalCount')
                ->get();
        });


        // Conversion rates
        $conversionRates = Cache::remember('admin_conversion_rates', 600, function () {
            return JobVacancy::with(['company' => function($q) { $q->withTrashed(); }])->withCount('jobApplications as totalCount')
                ->having('totalCount', '>', 0)
                ->limit(5)
                ->orderByDesc('totalCount')
                ->get()
                ->map(function ($job) {
                    if($job->viewCount > 0) {
                        $job->conversionRate = round( $job->totalCount / $job->viewCount * 100, 2);
                    } else {
                        $job->conversionRate = 0;
                    }
                    
                    
                    return $job;
                });
        });

            $analytics = [
                'activeUsers' => $activeUsers,
                'totalJobs' => $totalJobs,
                'totalApplications' => $totalApplications,
                'mostAppliedJobs' => $mostAppliedJobs,
                'conversionRates' => $conversionRates
            ];

        return $analytics;
    }

    private function companyOwnerDashboard()
    {

        $company = auth()->user()->company;

        // If the authenticated user has no company relation, return empty/zeroed analytics
        if (! $company) {
            $analytics = [
                'activeUsers' => 0,
                'totalJobs' => 0,
                'totalApplications' => 0,
                'mostAppliedJobs' => collect(),
                'conversionRates' => collect(),
            ];

            return $analytics;
        }

        // filter active users by applying to jobs of the company
        $activeUsers = Cache::remember('company_' . $company->id . '_active_users', 600, function () use ($company) {
            return User::where('last_login_at', '>=', now()->subDays(30))
                ->where('role', 'job_seeker')
                ->whereHas('jobApplications', function($query) use ($company) {
                    $query->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'));
                })
                ->count();
        });

        // total jobs of the company
        $totalJobs = Cache::remember('company_' . $company->id . '_total_jobs', 600, function () use ($company) {
            return $company->jobVacancies->count();
        });

        // total applications of the company
        $totalApplications = Cache::remember('company_' . $company->id . '_total_applications', 600, function () use ($company) {
            return JobApplication::whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))->count();
        });
        
        // most applied jobs of the company
        $mostAppliedJobs = Cache::remember('company_' . $company->id . '_most_applied_jobs', 600, function () use ($company) {
            return JobVacancy::with(['company' => function($q) { $q->withTrashed(); }])->withCount('jobApplications as totalCount')
                ->whereIn('id', $company->jobVacancies->pluck('id'))
                ->limit(5)
                ->orderByDesc('totalCount')
                ->get();
        });

        // conversion rates of the company
        $conversionRates = Cache::remember('company_' . $company->id . '_conversion_rates', 600, function () use ($company) {
            return JobVacancy::with(['company' => function($q) { $q->withTrashed(); }])->withCount('jobApplications as totalCount')
                ->whereIn('id', $company->jobVacancies->pluck('id'))
                ->having('totalCount', '>', 0)
                ->limit(5)
                ->orderByDesc('totalCount')
                ->get()
                ->map(function ($job) {
                    if($job->viewCount > 0) {
                        $job->conversionRate = round( $job->totalCount / $job->viewCount * 100, 2);
                    } else {
                        $job->conversionRate = 0;
                    }
                    return $job;
                });
        });
    

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];

        return $analytics;
    }
}