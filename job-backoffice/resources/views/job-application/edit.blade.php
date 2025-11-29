<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('app.applications.edit_status_title') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <form
                action="{{ route('job-applications.update', ['job_application' => $jobApplication->id, 'redirectToList' => request()->query('redirectToList')]) }}"
                method="POST">
                @csrf
                @method('PUT')

                <!-- Job Application Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold">{{ __('app.applications.details_title') }}</h3>
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">{{ __('app.applications.applicant_name') }}</label>
                        @if($jobApplication->user)
                            <span>{{ $jobApplication->user->name }}</span>
                        @else
                            <span class="text-sm text-gray-500">{{ __('app.applications.user_deleted') }}</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">{{ __('app.applications.job_vacancy') }}</label>
                        @if($jobApplication->jobVacancy)
                            <span>{{ $jobApplication->jobVacancy->title }}</span>
                        @else
                            <span class="text-sm text-gray-500">{{ __('app.applications.job_removed') }}</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">{{ __('app.dashboard.company') }}</label>
                        @if($jobApplication->jobVacancy && $jobApplication->jobVacancy->company)
                            <span>{{ $jobApplication->jobVacancy->company->name }}</span>
                        @else
                            <span class="text-sm text-gray-500">{{ __('app.applications.company_deleted') }}</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">{{ __('app.applications.ai_score') }}</label>
                        <span>{{ $jobApplication->aiGeneratedScore }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">{{ __('app.applications.ai_feedback') }}</label>
                        <span>{{ $jobApplication->aiGeneratedFeedback }}</span>
                    </div>


                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">{{ __('app.applications.status') }}</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm {{ $errors->has('status') ? 'outline-red-500 outline outline-1' : '' }}">
                            <option value="pending" {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : '' }}>Pending - Under Review
                            </option>
                            <option value="rejected" {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : '' }}>Rejected - Disqualified
                            </option>
                            <option value="accepted" {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : '' }}>Accepted - Qualified
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> 
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-applications.index') }}"
                        class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                        {{ __('app.common.cancel') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('app.applications.update_status_btn') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>