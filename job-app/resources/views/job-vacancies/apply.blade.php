<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            {{ __('app.job.apply_for', ['title' => $jobVacancy->title]) }}
        </h2>
    </x-slot>

    <!--
    ========================================================
    Alpine.js State Management
    Set isProcessing to false if there are validation errors,
    so the form is interactable upon page reload after validation failure.
    ========================================================
    -->
    <div class="py-12" x-data="{ 
        isProcessing: {{ $errors->any() ? 'false' : 'false' }}, 
        feedbackMessage: '{{ __('app.job.analyzing') }}' 
    }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Back Link -->
            <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}"
                class="text-indigo-400 hover:text-indigo-300 font-medium transition duration-150 inline-flex items-center mb-8">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ __('app.job.back_to_details') }}
            </a>

            <!-- Application Card -->
            <div class="bg-gray-800 shadow-2xl rounded-xl p-8 border border-indigo-700/30">

                <!-- Job Summary Header -->
                <div class="border-b border-gray-700 pb-6 mb-8">
                    <h1 class="text-3xl font-extrabold text-white">{{ $jobVacancy->title }}</h1>
                    <p class="text-lg text-gray-400 mt-1">
                        @if(isset($jobVacancy->company) && $jobVacancy->company)
                            <span class="font-semibold text-indigo-400">{{ $jobVacancy->company->name }}</span>
                        @else
                            <span class="text-red-500">{{ __('app.dashboard.company_deleted') }}</span>
                        @endif
                    </p>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-gray-300">
                        <span class="text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $jobVacancy->location }}
                        </span>
                        <span class="text-gray-600">•</span>
                        <span class="text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 16v-4m-6-4h12"></path></svg>
                            {{ '$' . number_format($jobVacancy->salary) }}
                        </span>
                        <span class="px-3 py-0.5 bg-indigo-600 text-white rounded-full text-xs font-semibold">{{ $jobVacancy->type }}</span>
                    </div>
                </div>

                <!-- Form -->
                <!-- Use @submit to set isProcessing = true and allow normal form submission -->
                <form action="{{ route('job-vacancies.process-application', $jobVacancy->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-10" @submit="isProcessing = true">
                    @csrf

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-900/50 border border-red-600 text-red-100 p-4 rounded-xl shadow-lg">
                            <p class="font-bold mb-2">Please Select or Upload Your Resume:</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <!-- Resume Selection Section -->
                    <div class="space-y-6">
                        <h3 class="text-2xl font-bold text-white border-b border-gray-700 pb-2">{{ __('app.job.select_resume') }}</h3>

                        <!-- Existing Resumes -->
                        <fieldset class="space-y-4">
                            <legend class="text-lg font-semibold text-gray-300 mb-3">{{ __('app.job.choose_existing') }}</legend>
                            <div class="space-y-3 p-4 bg-gray-900 rounded-lg border border-gray-700">
                                @forelse($resumes as $resume)
                                    <div class="flex items-center">
                                        <input type="radio" name="resume_option" id="existing_{{ $resume->id }}" value="{{ $resume->id }}"
                                            class="form-radio h-5 w-5 text-indigo-500 bg-gray-700 border-gray-600 focus:ring-indigo-500 cursor-pointer" />
                                        <label for="existing_{{ $resume->id }}" class="ml-3 text-white cursor-pointer flex-1">
                                            {{ $resume->filename }}
                                            <span class="text-gray-400 text-sm ml-2">(Updated: {{ $resume->updated_at->format('M d, Y') }})</span>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-gray-400 text-sm p-2">{{ __('app.job.no_existing_resumes') }}</p>
                                @endforelse
                            </div>
                        </fieldset>
                        
                        <!-- Divider -->
                        <div class="relative flex justify-center py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-700"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-gray-800 text-gray-500">{{ __('app.job.or') }}</span>
                            </div>
                        </div>

                        <!-- Upload New Resume -->
                        <!-- Upload New Resume -->
                        <div x-data="{ 
                            fileName: '', 
                            hasError: {{ $errors->has('resume_file') ? 'true' : 'false' }},
                            errorMessage: ''
                        }">
                            <div class="flex items-center mb-3">
                                <input x-ref="newResumeRadio" type="radio" name="resume_option" id="new_resume" value="new_resume"
                                    class="form-radio h-5 w-5 text-indigo-500 bg-gray-700 border-gray-600 focus:ring-indigo-500 cursor-pointer" />
                                <label class="ml-3 text-lg font-semibold text-gray-300 cursor-pointer" for="new_resume">{{ __('app.job.upload_new') }}</label>
                            </div>
                            
                            <label for="new_resume_file" class="block cursor-pointer">
                                <!-- Use x-bind:class for safe and reactive styling -->
                                <div class="border-2 border-dashed rounded-xl p-8 text-center transition duration-200"
                                    x-bind:class="{ 
                                        'border-indigo-500 bg-gray-900/50 shadow-lg shadow-indigo-500/10': $refs.newResumeRadio.checked, 
                                        'border-gray-700 hover:border-indigo-600': !$refs.newResumeRadio.checked,
                                        'border-red-500 !bg-red-900/10 shadow-lg shadow-red-500/10': hasError 
                                    }">
                                    
                                    <input @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            if (file.type !== 'application/pdf') {
                                                hasError = true;
                                                errorMessage = 'Only PDF files are allowed.';
                                                fileName = '';
                                                $event.target.value = ''; // Clear input
                                            } else if (file.size > 5 * 1024 * 1024) {
                                                hasError = true;
                                                errorMessage = 'File size must be less than 5MB.';
                                                fileName = '';
                                                $event.target.value = ''; // Clear input
                                            } else {
                                                fileName = file.name;
                                                $refs.newResumeRadio.checked = true;
                                                hasError = false;
                                                errorMessage = '';
                                            }
                                        } else {
                                            fileName = '';
                                        }
                                    " 
                                        type="file" name="resume_file" id="new_resume_file" class="hidden" accept="application/pdf" />
                                    
                                    <svg class="w-10 h-10 mx-auto mb-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 014 4v16a2 2 0 01-2 2H5a2 2 0 01-2-2v-5l4-4zM16 12l-4-4m4 4l-4 4m4-4h-8"></path></svg>

                                    <template x-if="!fileName">
                                            <p class="text-gray-400">{{ __('app.job.drag_drop') }} <span class="text-indigo-400 font-semibold">{{ __('app.job.browse') }}</span>.</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ __('app.job.max_size') }}</p>
                                            <p x-show="hasError" x-text="errorMessage" class="text-red-400 text-sm mt-2 font-semibold"></p>
                                        </div>
                                    </template>

                                    <template x-if="fileName">
                                        <div>
                                            <p x-text="fileName" class="mt-2 text-indigo-400 font-medium"></p>
                                            <p class="text-gray-400 text-sm mt-1">{{ __('app.job.file_ready') }}</p>
                                        </div>
                                    </template>

                                </div>
                            </label>
                        </div>
                    </div>


                    <!-- Submit Button -->
                    <!-- This section was fixed: the old @submit.prevent was replaced by @submit to allow form submission -->
                    <div class="pt-6 border-t border-gray-700/50">
                        <button type="submit" 
                            class="w-full relative flex items-center justify-center gap-3 py-4 rounded-xl text-lg font-bold text-white shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl overflow-hidden group disabled:cursor-not-allowed disabled:transform-none disabled:opacity-70"
                            x-bind:disabled="isProcessing"
                            x-bind:class="{ 
                                'bg-gradient-to-r from-indigo-600 to-pink-600 hover:from-indigo-500 hover:to-pink-500 ring-2 ring-indigo-500/50 ring-offset-2 ring-offset-gray-900': !isProcessing, 
                                'bg-gray-700 cursor-not-allowed': isProcessing 
                            }">
                            
                            <div x-show="!isProcessing" class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 group-hover:animate-shine"></div>

                            <span x-show="!isProcessing" class="flex items-center gap-2">
                                {{ __('app.job.submit_application') }}
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                            
                            <span x-show="isProcessing" class="flex items-center gap-3">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('app.job.processing') }}
                            </span>
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <!-- Full-Screen Attractive Loading Overlay -->
        <div x-show="isProcessing" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-gray-900/90 backdrop-blur-md"
            style="display: none;">
            
            <div class="ai-loader-container mb-8">
                <div class="ai-ring"></div>
                <div class="ai-ring"></div>
                <div class="ai-ring"></div>
                <div class="ai-core"></div>
            </div>

            <h3 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-pink-400 animate-pulse">
                <span x-text="feedbackMessage"></span>
            </h3>
            
            <p class="mt-4 text-gray-400 text-lg font-light tracking-wide">
                {{ __('app.job.analyzing') }}
            </p>
            
            <div class="w-64 h-1 bg-gray-800 rounded-full mt-8 overflow-hidden">
                <!-- Tailwind keyframe 'progress' will be defined in the style block -->
                <div class="h-full bg-gradient-to-r from-indigo-500 to-pink-500 w-1/2 animate-[progress_2s_ease-in-out_infinite]"></div>
            </div>

        </div>
        <!-- End of Loading Overlay -->

    </div>

  
</x-app-layout>