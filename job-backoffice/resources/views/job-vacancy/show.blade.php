<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('job-vacancies.index') }}" class="bg-gray-200 text-gray-800 hover:bg-gray-300 px-4 py-2 rounded-md">← {{ __('app.common.back') }}</a>
        </div>

        <!-- Wrapper -->
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- Company Details -->
            <div>
                <h3 class="text-lg font-bold">{{ __('app.jobs.info_title') }}</h3>
                <p><strong>{{ __('app.jobs.form_company') }}:</strong> {{ optional($jobVacancy->company)->name ?? 'N/A' }}</p>
                <p><strong>{{ __('app.jobs.form_location') }}:</strong> {{ $jobVacancy->location }}</p>
                <p><strong>{{ __('app.jobs.form_type') }}:</strong> {{ $jobVacancy->type }}</p>
                <p><strong>{{ __('app.jobs.salary') }}:</strong> ${{number_format($jobVacancy->salary, 2)  }}</p>
                <p><strong>{{ __('app.jobs.form_description') }}:</strong> {{ $jobVacancy->description }}</p>
            </div>

            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false']) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('app.common.edit') }}</a>
                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline-block">
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
                        <a href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'applications' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">{{ __('app.jobs.applications_tab') }}</a>
                    </li>
                </ul>
            </div>


            <!-- Tab Content -->
            <div>
                <!-- Applications Tab -->
                <div id="applications" class="{{ request('tab') == 'applications' || request('tab') == '' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">{{ __('app.applications.applicant_name') }}</th>
                                <th class="py-2 px-4 text-left bg-gray-100">{{ __('app.dashboard.job_title') }}</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">{{ __('app.applications.status') }}</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">{{ __('app.common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobVacancy->jobApplications as $application)
                                <tr>
                                    <td class="py-2 px-4">{{ optional($application->user)->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4">{{ optional($application->jobVacancy)->title ?? 'N/A' }}</td>
                                    <td class="py-2 px-4">{{ $application->status }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('job-applications.show', $application->id) }}" class="text-blue-500 hover:text-blue-700 underline">{{ __('app.applications.view_resume') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-2 px-4 text-center">{{ __('app.jobs.no_applications') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>