<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        @if (auth()->user()->role == 'admin')
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('companies.index') }}"
                    class="bg-gray-200 text-gray-800 hover:bg-gray-300 px-4 py-2 rounded-md">← {{ __('app.common.back') }}</a>
            </div>
        @endif

        <!-- Wrapper -->
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- Company Details -->
            <div>
                <h3 class="text-lg font-bold">{{ __('app.companies.info_title') }}</h3>
                <p><strong>{{ __('app.companies.owner_label') }}:</strong> {{ optional($company->owner)->name ?? 'N/A' }}</p>
                @if(optional($company->owner)->email)
                    <p><strong>{{ __('app.companies.email_label') }}:</strong> <a class="text-blue-500 hover:text-blue-700 underline" href="mailto:{{ optional($company->owner)->email }}">{{ optional($company->owner)->email }}</a></p>
                @else
                    <p><strong>{{ __('app.companies.email_label') }}:</strong> N/A</p>
                @endif
                <p><strong>{{ __('app.companies.address_label') }}:</strong> {{ $company->address }}</p>
                <p><strong>{{ __('app.companies.industry_label') }}:</strong> {{ $company->industry }}</p>
                <p><strong>{{ __('app.companies.website_label') }}:</strong> <a class="text-blue-500 hover:text-blue-700 underline"
                        href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>
            </div>

            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6">
                @if (auth()->user()->role == 'company_owner')
                    <a href="{{ route('my-company.edit') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('app.common.edit') }}</a>
                @else
                    <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('app.common.edit') }}</a>
                @endif


                @if (auth()->user()->role == 'admin')
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">{{ __('app.common.archive') }}</button>
                    </form>
                @endif
            </div>

            @if (auth()->user()->role == 'admin')
                    <!-- Tabs Navigation -->
                    <div class="mb-6">
                        <ul class="flex space-x-4">
                            <li>
                                <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                                    class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'jobs' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">{{ __('app.companies.jobs_tab') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applications']) }}"
                                    class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'applications' ? 'border-b-2 border-blue-500' : '' }}">{{ __('app.companies.applications_tab') }}</a>
                            </li>
                        </ul>
                    </div>


                    <!-- Tab Content -->
                    <div>
                        <!-- Jobs Tab -->
                        <div id="jobs" class="{{ request('tab') == 'jobs' || request('tab') == '' ? 'block' : 'hidden' }}">
                            <table class="min-w-full bg-gray-50 rounded-lg shadow">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">{{ __('app.jobs.form_title') }}</th>
                                        <th class="py-2 px-4 text-left bg-gray-100">{{ __('app.jobs.form_type') }}</th>
                                        <th class="py-2 px-4 text-left bg-gray-100">{{ __('app.jobs.form_location') }}</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">{{ __('app.common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($company->jobVacancies as $job)
                                        <tr>
                                            <td class="py-2 px-4">{{ $job->title }}</td>
                                            <td class="py-2 px-4">{{ $job->type }}</td>
                                            <td class="py-2 px-4">{{ $job->location }}</td>
                                            <td class="py-2 px-4">
                                                <a href="{{ route('job-vacancies.show', $job->id) }}"
                                                    class="text-blue-500 hover:text-blue-700 underline">{{ __('app.applications.view_resume') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <!-- Applications Tab -->
                        <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
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
                                    @if ($company->jobApplications && $company->jobApplications->count())
                                        @foreach ($company->jobApplications as $application)
                                        <tr>
                                            <td class="py-2 px-4">{{ optional($application->user)->name ?? 'N/A' }}</td>
                                            <td class="py-2 px-4">{{ optional($application->jobVacancy)->title ?? 'N/A' }}</td>
                                            <td class="py-2 px-4">{{ $application->status }}</td>
                                            <td class="py-2 px-4">
                                                <a href="{{ route('job-applications.show', $application->id) }}"
                                                    class="text-blue-500 hover:text-blue-700 underline">{{ __('app.applications.view_resume') }}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="py-2 px-4" colspan="4">{{ __('app.jobs.no_applications') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
    </div>

</x-app-layout>