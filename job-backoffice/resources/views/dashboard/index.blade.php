<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 flex flex-col gap-6">
        <!-- Overview Cards - Icons Added -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            {{-- Metric Card 1: Active Users --}}
            <x-metric-card 
                title="Active Users" 
                :value="$analytics['activeUsers']" 
                subtitle="Last 30 days" 
                color="blue" {{-- Changed to 'blue' for variety --}}
                icon="Users" 
                href="{{ route('users.index') }}" />
            
            {{-- Metric Card 2: Total Jobs --}}
            <x-metric-card 
                title="Total Jobs" 
                :value="$analytics['totalJobs']" 
                subtitle="All time" 
                color="green" {{-- Changed to 'green' for variety --}}
                icon="Briefcase" 
                href="{{ route('job-vacancies.index') }}" />
            
            {{-- Metric Card 3: Total Applications --}}
            <x-metric-card 
                title="Total Applications" 
                :value="$analytics['totalApplications']" 
                subtitle="All time" 
                color="indigo" 
                icon="FileText" 
                href="{{ route('job-applications.index') }}" />
        </div>

        <!-- Most Applied Jobs -->
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            {{-- Title with Icon: TrendingUp --}}
            <h3 class="text-lg font-bold text-gray-900 flex items-center space-x-2 rtl:space-x-reverse">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline><polyline points="16 17 22 17 22 11"></polyline></svg>
                <span>Most Applied Jobs</span>
            </h3>
            
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Job Title</th>
                            @if(auth()->user()->role == 'admin')
                                <th class="py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Company</th>
                            @endif
                            <th class="py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($analytics['mostAppliedJobs'] as $job)
                            <tr>
                                <td class="py-4 whitespace-nowrap text-sm text-gray-900">{{ $job->title }}</td>
                                @if(auth()->user()->role == 'admin')
                                    <td class="py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if($job->company)
                                            {{ $job->company->name }}
                                        @else
                                            <span class="text-xs text-red-500">Company deleted</span>
                                        @endif
                                    </td>
                                @endif
                                <td class="py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $job->totalCount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Conversion Rates -->
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            {{-- Title with Icon: BarChart --}}
            <h3 class="text-lg font-bold text-gray-900 flex items-center space-x-2 rtl:space-x-reverse">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500"><line x1="12" x2="12" y1="20" y2="10"></line><line x1="18" x2="18" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="16"></line></svg>
                <span>Conversion Rates</span>
            </h3>
            
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Job Title</th>
                            <th class="py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Views</th>
                            <th class="py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Applications</th>
                            <th class="py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($analytics['conversionRates'] as $conversionRate)
                            <tr>
                                <td class="py-4 whitespace-nowrap text-sm text-gray-900">{{ $conversionRate->title }}</td>
                                <td class="py-4 whitespace-nowrap text-sm text-gray-600">{{ $conversionRate->viewCount }}</td>
                                <td class="py-4 whitespace-nowrap text-sm text-gray-600">{{ $conversionRate->totalCount }}</td>
                                <td class="py-4 whitespace-nowrap text-sm font-medium">
                                    <x-status-badge :value="$conversionRate->conversionRate" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>