<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <!-- Main Content Container -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-3xl rounded-xl p-6 sm:p-8 border border-indigo-700/50">

                <!-- Back Link -->
                <a href="{{ route('dashboard') }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition duration-150 inline-flex items-center mb-10 text-sm sm:text-base">
                    <!-- Icon: Updated appearance -->
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Job Listings
                </a>

                <!-- Job Header: Title, Company, Metadata, and Apply Button -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center border-b border-gray-700 pb-6 mb-8">
                    <div>
                        <!-- Title -->
                        <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">{{ $jobVacancy->title }}</h1>

                        <!-- Company Name -->
                        <p class="text-xl sm:text-2xl text-gray-400 mt-2">
                            @if(isset($jobVacancy->company) && $jobVacancy->company)
                                <span class="font-bold text-indigo-400 hover:text-indigo-300 transition">{{ $jobVacancy->company->name }}</span>
                            @else
                                <span class="text-red-500 font-semibold">Company Deleted</span>
                            @endif
                        </p>

                        <!-- Metadata Row with Enhanced Icons -->
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-4 text-gray-300">
                            <!-- Location -->
                            <div class="flex items-center text-sm sm:text-base">
                                <!-- Icon: Pin -->
                                <svg class="w-4 h-4 mr-1.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="font-medium">{{ $jobVacancy->location }}</span>
                            </div>
                            <!-- Salary -->
                            <div class="flex items-center text-sm sm:text-base">
                                <!-- Icon: Currency -->
                                <svg class="w-4 h-4 mr-1.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 16v-4m-6-4h12"></path></svg>
                                <span class="font-medium">{{ '$' . number_format($jobVacancy->salary) }}</span>
                            </div>
                            <!-- Type Badge (Enhanced Styling) -->
                            <span class="px-3 py-1 bg-indigo-600 text-white rounded-full text-xs font-semibold shadow-md ring-2 ring-offset-2 ring-indigo-500 ring-offset-gray-800">{{ $jobVacancy->type }}</span>
                        </div>
                    </div>

                    <!-- Apply Button (Enhanced Styling) -->
                    <div class="mt-6 lg:mt-0 flex-shrink-0">
                        <a href="{{ route('job-vacancies.apply', $jobVacancy->id) }}"
                           class="inline-flex items-center justify-center text-lg font-bold bg-gradient-to-r from-indigo-600 to-pink-600 text-white rounded-full px-8 py-3 shadow-2xl transition duration-500 ease-in-out hover:from-indigo-700 hover:to-pink-700 transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-indigo-500/50">
                            Apply Now
                            <!-- Icon: Arrow -->
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Job Description and Overview Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
                    
                    <!-- Job Description (2/3 width on desktop) -->
                    <div class="lg:col-span-2">
                        <h2 class="text-2xl font-bold text-white border-b border-gray-700/50 pb-3 mb-6">Job Description</h2>
                        <!-- Added max-w-prose for better readability on long lines -->
                        <div class="text-gray-300 leading-relaxed space-y-4 prose prose-invert max-w-none">
                            <p>{!! nl2br(e($jobVacancy->description)) !!}</p>
                            
                            <!-- Note: Changed {{ $jobVacancy->description }} to use {!! nl2br(e($jobVacancy->description)) !!} 
                                to preserve line breaks if the description is plain text, 
                                and still protect against XSS if it contained HTML.
                            -->
                        </div>
                    </div>
                    
                    <!-- Job Overview (1/3 width on desktop) - Sticky on large screens -->
                    <div class="lg:col-span-1">
                        <div class="lg:sticky lg:top-8">
                            <h2 class="text-2xl font-bold text-white border-b border-gray-700/50 pb-3 mb-6">Job Overview</h2>
                            
                            <div class="bg-gray-900/70 rounded-xl p-6 space-y-6 border border-indigo-700/50 shadow-lg">
                                
                                <!-- Published Date -->
                                <div class="flex justify-between items-center border-b border-gray-700/50 pb-3">
                                    <p class="text-sm font-semibold text-gray-400">Published Date</p>
                                    <p class="text-white text-base font-medium">{{ $jobVacancy->created_at->format('M d, Y') }}</p>
                                </div>
                                
                                <!-- Company -->
                                <div class="flex justify-between items-center border-b border-gray-700/50 pb-3">
                                    <p class="text-sm font-semibold text-gray-400">Company</p>
                                    <p class="text-white text-base">
                                        @if(isset($jobVacancy->company) && $jobVacancy->company)
                                            <a href="#" class="hover:text-indigo-400 transition">{{ $jobVacancy->company->name }}</a>
                                        @else
                                            <span class="text-red-400 font-medium">—</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <!-- Location -->
                                <div class="flex justify-between items-center border-b border-gray-700/50 pb-3">
                                    <p class="text-sm font-semibold text-gray-400">Location</p>
                                    <p class="text-white text-base font-medium">{{ $jobVacancy->location }}</p>
                                </div>
                                
                                <!-- Salary -->
                                <div class="flex justify-between items-center border-b border-gray-700/50 pb-3">
                                    <p class="text-sm font-semibold text-gray-400">Salary</p>
                                    <p class="text-pink-400 text-lg font-extrabold">{{ '$' . number_format($jobVacancy->salary) }}</p>
                                </div>
                                
                                <!-- Type -->
                                <div class="flex justify-between items-center border-b border-gray-700/50 pb-3">
                                    <p class="text-sm font-semibold text-gray-400">Employment Type</p>
                                    <p class="text-white text-base font-medium">{{ $jobVacancy->type }}</p>
                                </div>
                                
                                <!-- Category -->
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-semibold text-gray-400">Category</p>
                                    <p class="text-white text-base">
                                        @if(isset($jobVacancy->jobCategory) && $jobVacancy->jobCategory)
                                            {{ $jobVacancy->jobCategory->name }}
                                        @else
                                            <span class="text-gray-300">Uncategorized</span>
                                        @endif
                                    </p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>