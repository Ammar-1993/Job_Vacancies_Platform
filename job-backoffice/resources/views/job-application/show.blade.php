<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($jobApplication->user)
                {{ $jobApplication->user->name }}
            @else
                <span class="text-sm text-gray-500">{{ __('app.applications.user_deleted') }}</span>
            @endif
            | {{ __('app.applications.applied_to') }}
            @if($jobApplication->jobVacancy)
                {{ $jobApplication->jobVacancy->title }}
            @else
                <span class="text-sm text-gray-500">{{ __('app.applications.job_removed') }}</span>
            @endif
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('job-applications.index') }}"
                class="bg-gray-200 text-gray-800 hover:bg-gray-300 px-4 py-2 rounded-md">← {{ __('app.common.back') }}</a>
        </div>

        <!-- Wrapper -->
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- Application Details -->
            <div>
                <h3 class="text-lg font-bold">{{ __('app.applications.details_title') }}</h3>
                <p><strong>{{ __('app.applications.applicant') }}:</strong>
                    @if($jobApplication->user)
                        {{ $jobApplication->user->name }}
                    @else
                        <span class="text-sm text-gray-600">{{ __('app.applications.user_deleted') }}</span>
                    @endif
                </p>
                <p><strong>{{ __('app.applications.job_vacancy') }}:</strong>
                    @if($jobApplication->jobVacancy)
                        {{ $jobApplication->jobVacancy->title }}
                    @else
                        <span class="text-sm text-gray-600">{{ __('app.applications.job_removed') }}</span>
                    @endif
                </p>
                <p><strong>{{ __('app.dashboard.company') }}:</strong>
                    @if($jobApplication->jobVacancy && $jobApplication->jobVacancy->company)
                        {{ $jobApplication->jobVacancy->company->name }}
                    @else
                        <span class="text-sm text-gray-600">{{ __('app.applications.company_deleted') }}</span>
                    @endif
                </p>
                <p><strong>{{ __('app.applications.status') }}:</strong> <span
                        class="@if($jobApplication->status == 'accepted') text-green-600 @elseif($jobApplication->status == 'rejected') text-red-600 @else text-purple-600 @endif">{{ $jobApplication->status }}
                    </span></p>
                <p><strong>{{ __('app.applications.resume_tab') }}:</strong>
                    @if($jobApplication->resume && $jobApplication->resume->fileUri)
                        <a class="text-blue-500 hover:text-blue-700 underline" href="{{ $jobApplication->resume->fileUri }}" target="_blank">{{ $jobApplication->resume->fileUri }}</a>
                    @else
                        <span class="text-sm text-gray-600">{{ __('app.applications.no_resume') }}</span>
                    @endif
                </p>
            </div>

            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-applications.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false']) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('app.common.edit') }}</a>
                <form action="{{ route('job-applications.destroy', ['job_application' => $jobApplication->id]) }}"
                    method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">{{ __('app.common.archive') }}</button>
                </form>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'resume']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'resume' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">{{ __('app.applications.resume_tab') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'AIFeedback']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'AIFeedback' ? 'border-b-2 border-blue-500' : '' }}">{{ __('app.applications.ai_feedback_tab') }}</a>
                    </li>
                </ul>
            </div>


            <!-- Tab Content -->
            <div>
                <!-- Resume Tab -->
                <div id="resume" class="{{ request('tab') == 'resume' || request('tab') == '' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">{{ __('app.applications.summary') }}</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">{{ __('app.applications.skills') }}</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">{{ __('app.applications.experience') }}</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">{{ __('app.applications.education') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4">{{ $jobApplication->resume->summary }}</td>
                                <td class="py-2 px-4">{{ $jobApplication->resume->skills }}</td>
                                <td class="py-2 px-4">{{ $jobApplication->resume->experience }}</td>
                                <td class="py-2 px-4">{{ $jobApplication->resume->education }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <!-- AI Feedback Tab -->
                <div id="AIFeedback" class="{{ request('tab') == 'AIFeedback' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">{{ __('app.applications.ai_score') }}</th>
                                <th class="py-2 px-4 text-left bg-gray-100">{{ __('app.applications.ai_feedback') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4">{{ $jobApplication->aiGeneratedScore }}</td>
                                <td class="py-2 px-4">{{ $jobApplication->aiGeneratedFeedback }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>