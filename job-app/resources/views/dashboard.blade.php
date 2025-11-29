<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            {{ __('app.dashboard.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Main Content Wrapper: Dark background, large shadow, rounded corners -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 shadow-2xl rounded-xl p-8 border border-indigo-700/30">
                
                <!-- Welcome Section -->
                <h3 class="text-white text-3xl font-extrabold mb-8 border-b border-indigo-500/50 pb-4">
                    👋 {{ __('app.dashboard.welcome_back') }} <span class="text-indigo-400">{{ Auth::user()->name }}</span>!
                </h3>

                <!-- Stats Overview Section -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                    <!-- Stat Card 1: Total Jobs -->
                    <div class="bg-indigo-900/40 p-5 rounded-xl shadow-lg hover:ring-2 ring-indigo-500 transition duration-300">
                        <div class="flex items-center space-x-4">
                            <!-- Icon Placeholder (e.g., Briefcase Icon) -->
                            <div class="p-3 bg-indigo-500 rounded-full text-white">
                                <!-- SVG for Briefcase -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 16v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2m4 0h6m-3 0v-2"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-300">{{ __('app.dashboard.total_jobs') }}</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($jobs->total() ?? 0) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stat Card 2: Saved Jobs (Mock Data) -->
                    <div class="bg-gray-800/60 p-5 rounded-xl shadow-lg hover:ring-2 ring-blue-500 transition duration-300">
                        <div class="flex items-center space-x-4">
                            <!-- Icon Placeholder (e.g., Heart Icon) -->
                            <div class="p-3 bg-blue-500 rounded-full text-white">
                                <!-- SVG for Heart -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-300">{{ __('app.dashboard.saved_jobs') }}</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($savedJobsCount) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stat Card 3: Applications Sent (Mock Data) -->
                    <div class="bg-gray-800/60 p-5 rounded-xl shadow-lg hover:ring-2 ring-green-500 transition duration-300">
                        <div class="flex items-center space-x-4">
                            <!-- Icon Placeholder (e.g., Send Icon) -->
                            <div class="p-3 bg-green-500 rounded-full text-white">
                                <!-- SVG for Send -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-300">{{ __('app.dashboard.applications_sent') }}</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($applicationsSentCount) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stat Card 4: New Today (Mock Data) -->
                    <div class="bg-gray-800/60 p-5 rounded-xl shadow-lg hover:ring-2 ring-yellow-500 transition duration-300">
                        <div class="flex items-center space-x-4">
                            <!-- Icon Placeholder (e.g., Lightning Icon) -->
                            <div class="p-3 bg-yellow-500 rounded-full text-white">
                                <!-- SVG for Flash -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-300">{{ __('app.dashboard.new_today') }}</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($newJobsTodayCount) }}</p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Search & Filters -->
                <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mb-8">
                    
                    <!-- Search Bar -->
                    <form action="{{ route('dashboard') }}" method="get" class="flex flex-grow max-w-lg">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="flex-grow p-3 rounded-l-lg bg-gray-800 text-white placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border border-gray-700"
                            placeholder="{{ __('app.dashboard.search_placeholder') }}">
                        <button type="submit"
                            class="bg-indigo-600 text-white p-3 rounded-r-lg border border-indigo-600 hover:bg-indigo-700 transition duration-150">
                            <!-- Search Icon SVG -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>

                        @if (request('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif

                        @if (request('search') || request('filter'))
                            <a href="{{ route('dashboard', ['filter' => request('filter')]) }}"
                                class="text-gray-400 p-3 rounded-lg ml-2 hover:text-white transition duration-150 flex items-center justify-center border border-gray-700 bg-gray-800/50"
                                title="Clear Search & Filters">
                                <!-- Clear Icon SVG -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </form>

                    <!-- Filters (Styled as dynamic badges/pills) -->
                    <div class="flex flex-wrap gap-2">
                        @php
                            $filters = \App\Enums\JobType::cases();
                        @endphp

                        @foreach ($filters as $type)
                            @php
                                $isActive = request('filter') === $type->value;
                                $class = $isActive 
                                    ? 'bg-indigo-600 text-white font-semibold ring-2 ring-indigo-300 shadow-md' 
                                    : 'bg-gray-700 text-gray-300 hover:bg-indigo-500/70 hover:text-white';
                                $route = route('dashboard', ['filter' => $isActive ? null : $type->value, 'search' => request('search')]);
                            @endphp
                            <a href="{{ $route }}"
                                class="{{ $class }} px-4 py-2 rounded-full text-sm transition duration-200 ease-in-out">
                                {{ $type->label() }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Job List with Skeleton Loader -->
                <div class="space-y-4 mt-6" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
                    
                    <!-- Skeleton Loader -->
                    <template x-if="loading">
                        <div class="space-y-4">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="bg-gray-800/60 p-6 rounded-xl shadow-lg border border-gray-700/50 animate-pulse">
                                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                        <div class="w-full">
                                            <div class="h-6 bg-gray-700 rounded w-1/3 mb-4"></div>
                                            <div class="h-4 bg-gray-700 rounded w-1/4 mb-2"></div>
                                            <div class="h-4 bg-gray-700 rounded w-1/5"></div>
                                        </div>
                                        <div class="flex items-center space-x-4 mt-4 md:mt-0">
                                            <div class="h-8 bg-gray-700 rounded w-20"></div>
                                            <div class="h-10 bg-gray-700 rounded w-24"></div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </template>

                    <!-- Actual Content -->
                    <div x-show="!loading" style="display: none;">
                        @forelse ($jobs as $job)
                        <!-- Job Item Card -->
                        <div class="bg-gray-800/60 p-6 rounded-xl shadow-lg hover:bg-gray-700/70 transition duration-200 border border-gray-700/50">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                
                                <!-- Job Details -->
                                <div class="mb-4 md:mb-0">
                                    <a href="{{ route('job-vacancies.show', $job->id) }}"
                                        class="text-xl font-bold text-indigo-400 hover:text-indigo-300 hover:underline transition duration-150 flex items-center">
                                        <!-- Title Icon -->
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1v-3.25M17 14V9.5a4.5 4.5 0 00-9 0V14h9zM12 3v1M20 10l-1 .75M4 10l1 .75"></path></svg>
                                        {{ $job->title }}
                                    </a>
                                    
                                    <p class="text-base text-gray-300 mt-1">
                                        @if(isset($job->company) && $job->company)
                                            <!-- Company & Location -->
                                            <span class="font-medium text-gray-400">{{ $job->company->name }}</span>
                                            <span class="mx-2 text-gray-500">•</span>
                                            <span class="text-gray-400 flex items-center mt-1">
                                                <!-- Location Icon -->
                                                <svg class="w-4 h-4 mr-1 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $job->location }}
                                            </span>
                                        @else
                                            <span class="text-sm text-red-500">{{ __('app.dashboard.company_deleted') }}</span>
                                            <span class="text-gray-400 flex items-center mt-1">
                                                <svg class="w-4 h-4 mr-1 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $job->location }}
                                            </span>
                                        @endif
                                    </p>
                                    
                                    <!-- Salary -->
                                    <p class="text-sm text-gray-400 mt-2 flex items-center">
                                        <!-- Dollar Icon -->
                                        <svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V9m0 3v2.25M8 12h8m-11 3.5a9 9 0 1118 0M3 12a9 9 0 009 9c1.674 0 3.298-.488 4.657-1.404"></path></svg>
                                        <span class="font-semibold text-green-400">{{ '$' . number_format($job->salary) }}</span> {{ __('app.job.salary_year') }}
                                    </p>
                                </div>
                                
                                <!-- Job Type Badge & Action -->
                                <div class="flex items-center space-x-4">
                                    <span class="bg-indigo-700 text-white px-4 py-1.5 rounded-full text-sm font-medium shadow-md">
                                        {{ $job->type }}
                                    </span>
                                    
                                    <form action="{{ route('job-vacancies.save', $job->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-full hover:bg-gray-700 transition duration-150 group" title="Save Job">
                                            @if(auth()->user()->savedJobs->contains($job->id))
                                                <!-- Filled Heart (Saved) -->
                                                <svg class="w-6 h-6 text-pink-500 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            @else
                                                <!-- Outline Heart (Not Saved) -->
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-pink-500 transition duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>

                                    <a href="{{ route('job-vacancies.show', $job->id) }}"
                                        class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition duration-150 text-sm font-semibold">
                                        {{ __('app.dashboard.view_details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-10 bg-gray-800 rounded-xl">
                            <p class="text-indigo-400 text-3xl font-bold">{{ __('app.dashboard.no_jobs') }}</p>
                            <p class="text-gray-400 mt-2">{{ __('app.dashboard.no_jobs_subtitle') }}</p>
                        </div>
                    @endforelse
                    </div>
                </div>

                <!-- Pagination Links -->
                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>