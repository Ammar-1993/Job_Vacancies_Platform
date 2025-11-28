<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::query();

        if ($request->has('search') && $request->has('filter')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('location', 'like', '%' . $request->search . '%')
                    ->orWhereHas('company', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->where('type', $request->filter);
        }

        if ($request->has('search') && $request->filter === null) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%')
                ->orWhereHas('company', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
        }

        if ($request->has('filter') && $request->search === null) {
            $query->where('type', $request->filter);
        }

        // Fix N+1 by eager loading 'company'
        $jobs = $query->with('company')->latest()->paginate(10)->withQueryString();

        // Statistics
        $applicationsSentCount = JobApplication::where('userId', auth()->id())->count();
        $newJobsTodayCount = JobVacancy::whereDate('created_at', Carbon::today())->count();
        $savedJobsCount = auth()->user()->savedJobs()->count();

        return view('dashboard', compact('jobs', 'applicationsSentCount', 'newJobsTodayCount', 'savedJobsCount'));
    }
}