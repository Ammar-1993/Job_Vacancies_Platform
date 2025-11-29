<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Http\Requests\JobApplicationUpdateRequest;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start Query
        $query = JobApplication::latest();

        // 1. Role Check: Filter for Company Owners
        if (auth()->user()->role == 'company_owner') {
            $company = auth()->user()->company;
            if (! $company) {
                // No company attached to this user — return no results
                $query->whereRaw('0 = 1');
            } else {
                $query->whereHas('jobVacancy', function($q) use ($company) {
                    $q->where('companyId', $company->id);
                });
            }
        }

        // 2. Search Logic (New)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // 3. Status Filter Logic (New)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Archived Check
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        // Eager load relations to avoid N+1
        $query->with(['user', 'jobVacancy.company']);

        // Pagination (Appending query parameters ensures filters persist across pages)
        $jobApplications = $query->paginate(10)->onEachSide(1)->withQueryString();
        
        return view('job-application.index', compact('jobApplications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::with(['user', 'jobVacancy.company'])->findOrFail($id);
        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->update([
            'status' => $request->input('status'),
        ]);

        if($request->query('redirectToList') == 'false'){
            return redirect()->route('job-applications.show', $id)->with('success', 'Applicant status updated successfully!');
        }

        return redirect()->route('job-applications.index')->with('success', 'Applicant status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route('job-applications.index')->with('success', 'Applicant archived successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('job-applications.index', ['archived' => 'true'])->with('success', 'Applicant restored successfully');
    }
}