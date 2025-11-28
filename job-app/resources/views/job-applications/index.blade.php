<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    <!-- Success Message -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-700/80 text-white p-4 rounded-xl shadow-lg border border-green-600">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="py-12">
        <!-- Main Content Container -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 shadow-2xl rounded-xl p-8 border border-indigo-700/30 space-y-6">

                <!-- List of Job Applications -->
                @forelse ($jobApplications as $jobApplication)
                    <div class="bg-gray-800/70 p-6 rounded-xl shadow-lg border border-gray-700 hover:bg-gray-700/80 transition duration-200">
                        
                        <!-- Header and Job Details -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-700 pb-4 mb-4">
                            
                            <div>
                                <h3 class="text-xl font-extrabold text-indigo-400">
                                    {{ $jobApplication->jobVacancy?->title ?? 'Job Removed' }}
                                </h3>
                                
                                <p class="text-base text-gray-400 mt-1">
                                    <!-- Company Name -->
                                    @if(isset($jobApplication->jobVacancy) && $jobApplication->jobVacancy && isset($jobApplication->jobVacancy->company) && $jobApplication->jobVacancy->company)
                                        <span class="font-semibold text-gray-300">{{ $jobApplication->jobVacancy->company->name }}</span>
                                    @else
                                        <span class="font-semibold text-red-500">Company Deleted</span>
                                    @endif
                                    
                                    <span class="mx-2 text-gray-600">•</span>
                                    
                                    <!-- Location -->
                                    <span class="text-sm text-gray-500">{{ $jobApplication->jobVacancy->location ?? 'Unknown Location' }}</span>
                                </p>
                            </div>

                            <!-- Applied Date and Job Type -->
                            <div class="flex items-center space-x-4 mt-3 md:mt-0">
                                <p class="text-sm text-gray-500">Applied on: <span class="text-gray-300 font-medium">{{ $jobApplication->created_at->format('d M Y') }}</span></p>
                                
                                <!-- Job Type Badge -->
                                @if(isset($jobApplication->jobVacancy) && $jobApplication->jobVacancy && isset($jobApplication->jobVacancy->type))
                                    <span class="px-3 py-1 bg-blue-700 text-white rounded-full text-xs font-semibold shadow-md">{{ $jobApplication->jobVacancy->type }}</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-600 text-white rounded-full text-xs font-semibold">—</span>
                                @endif
                            </div>
                        </div>

                        <!-- Resume and Score/Status Section -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 items-start">
                            
                            <!-- Resume Details -->
                            <div class="flex flex-col space-y-2 col-span-1 border-r md:border-r-gray-700 pr-4">
                                <span class="text-sm font-medium text-gray-400">Application File:</span>
                                
                                <div class="flex items-center gap-2">
                                    <span class="text-white text-base font-medium">{{ $jobApplication->resume->filename ?? 'N/A' }}</span>
                                    
                                    @php
                                        /** @var \Illuminate\Filesystem\FilesystemAdapter $cloudDisk */
                                        $cloudDisk = Storage::disk('cloud');
                                    @endphp
                                    
                                    @if(isset($jobApplication->resume) && $jobApplication->resume && $jobApplication->resume->fileUri)
                                        <a href="{{ $cloudDisk->url($jobApplication->resume->fileUri) }}" target="_blank" 
                                           class="text-indigo-500 hover:text-indigo-400 font-medium text-sm transition duration-150 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    @else
                                        <span class="text-gray-500 text-sm">No Resume File</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Status and Score Badges -->
                            <div class="flex items-center gap-4 col-span-2 md:col-span-1">
                                <!-- Status Badge -->
                                @php
                                    $status = $jobApplication->status;
                                    $statusClass = match ($status) {
                                        'pending' => 'bg-yellow-600/70 text-yellow-100',
                                        'accepted' => 'bg-green-600/70 text-green-100',
                                        'rejected' => 'bg-red-600/70 text-red-100',
                                        default => 'bg-gray-600/70 text-gray-100',
                                    };
                                @endphp
                                <p class="text-sm {{ $statusClass }} w-fit px-3 py-1.5 rounded-lg font-semibold shadow-inner">
                                    Status: <span class="capitalize">{{ $jobApplication->status }}</span>
                                </p>

                                <!-- Score Badge -->
                                <p class="text-sm bg-indigo-600/70 text-white w-fit px-3 py-1.5 rounded-lg font-semibold shadow-inner">
                                    AI Score: <span class="text-lg font-bold">{{ $jobApplication->aiGeneratedScore }}</span>%
                                </p>
                            </div>
                        </div>

                        <!-- AI Feedback Section -->
                        <div class="flex flex-col gap-2 mt-4 pt-4 border-t border-gray-700/50">
                            <h4 class="text-lg font-bold text-gray-300 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                AI Feedback:
                            </h4>
                            <p class="text-sm text-gray-400 leading-relaxed">{{ $jobApplication->aiGeneratedFeedback }}</p>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center p-12 bg-gray-800 rounded-xl border border-gray-700">
                        <svg class="w-16 h-16 mx-auto text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h14zM5 11V9a2 2 0 012-2h3a2 2 0 012 2v2m0 0h2m-2 0h2"></path></svg>
                        <p class="text-indigo-400 text-2xl font-bold mt-4">No Applications Submitted Yet</p>
                        <p class="text-gray-400 mt-2">Start exploring job vacancies on the Dashboard to find your next opportunity!</p>
                    </div>
                @endforelse

                <!-- Pagination Links -->
                <div class="mt-8">
                    {{ $jobApplications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>