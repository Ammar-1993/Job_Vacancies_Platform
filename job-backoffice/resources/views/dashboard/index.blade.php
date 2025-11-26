<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 flex flex-col gap-6">
        <!-- Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-metric-card title="Active Users" :value="$analytics['activeUsers']" subtitle="Last 30 days" color="indigo-600" href="{{ route('users.index') }}" />
            <x-metric-card title="Total Jobs" :value="$analytics['totalJobs']" subtitle="All time" color="indigo-600" href="{{ route('job-vacancies.index') }}" />
            <x-metric-card title="Total Applications" :value="$analytics['totalApplications']" subtitle="All time" color="indigo-600" href="{{ route('job-applications.index') }}" />
        </div>

        <!-- Most Applied Jobs -->
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Most Applied Jobs</h3>
            <div class="mt-3">
                <button type="button" class="inline-flex items-center text-xs text-gray-500" title="Top 5 most applied jobs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                    <span class="sr-only">Top 5 most applied jobs</span>
                </button>
            </div>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-3 text-xs font-semibold text-gray-500">Job Title</th>
                            @if(auth()->user()->role == 'admin')
                                <th class="py-3 text-xs font-semibold text-gray-500">Company</th>
                            @endif
                            <th class="py-3 text-xs font-semibold text-gray-500">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($analytics['mostAppliedJobs'] as $job)
                            <tr>
                                <td class="py-4">{{ $job->title }}</td>
                                @if(auth()->user()->role == 'admin')
                                    <td class="py-4">
                                        @if($job->company)
                                            {{ $job->company->name }}
                                        @else
                                            <span class="text-sm text-gray-500">Company deleted</span>
                                        @endif
                                    </td>
                                @endif
                                <td class="py-4">{{ $job->totalCount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Conversion Rates -->
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Conversion Rates</h3>
            <div class="mt-3">
                <button type="button" class="inline-flex items-center text-xs text-gray-500" title="Top 5 conversion rates">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                    <span class="sr-only">Top 5 conversion rates</span>
                </button>
            </div>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-3 text-xs font-semibold text-gray-500">Job Title</th>
                            <th class="py-3 text-xs font-semibold text-gray-500">Views</th>
                            <th class="py-3 text-xs font-semibold text-gray-500">Applications</th>
                            <th class="py-3 text-xs font-semibold text-gray-500">Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($analytics['conversionRates'] as $conversionRate)
                            <tr>
                                <td class="py-4">{{ $conversionRate->title }}</td>
                                <td class="py-4">{{ $conversionRate->viewCount }}</td>
                                <td class="py-4">{{ $conversionRate->totalCount }}</td>
                                <td class="py-4"><x-status-badge :value="$conversionRate->conversionRate" /></td>
                            </tr>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>