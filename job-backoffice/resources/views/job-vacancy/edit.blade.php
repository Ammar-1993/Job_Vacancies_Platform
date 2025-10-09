<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <form action="{{ route('job-vacancies.update', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => request()->query('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Job Vacancy Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold">Job Vacancy Details</h3>
                    <p class="text-sm mb-2">Enter the job vacancy details</p>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $jobVacancy->title) }}"
                            class="{{ $errors->has('title') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $jobVacancy->location) }}"
                            class="{{ $errors->has('location') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block text-sm font-medium text-gray-700">Expected Salary
                            (USD)</label>
                        <input type="number" name="salary" id="salary" value="{{ old('salary', $jobVacancy->salary) }}"
                            class="{{ $errors->has('salary') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('salary')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm {{ $errors->has('type') ? 'outline-red-500 outline outline-1' : '' }}">
                            <option value="Full-Time" {{ old('type', $jobVacancy->type) == 'Full-Time' ? 'selected' : '' }}>Full-Time
                            </option>
                            <option value="Contract" {{ old('type', $jobVacancy->type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Remote" {{ old('type', $jobVacancy->type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                            <option value="Hybrid" {{ old('type', $jobVacancy->type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Select Dropdown -->
                    <div class="mb-4">
                        <label for="companyId" class="block text-sm font-medium text-gray-700">Company</label>
                        <select name="companyId" id="companyId"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm {{ $errors->has('company') ? 'outline-red-500 outline outline-1' : '' }}">
                            @foreach ($companies as $company)
                                <option {{ old('companyId', $jobVacancy->companyId) == $company->id ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('companyId')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Job Category Select Dropdown -->
                    <div class="mb-4">
                        <label for="jobCategoryId" class="block text-sm font-medium text-gray-700">Job Category</label>
                        <select name="jobCategoryId" id="jobCategoryId"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm {{ $errors->has('jobCategoryId') ? 'outline-red-500 outline outline-1' : '' }}">
                            @foreach ($jobCategories as $jobCategory)
                                <option {{ old('jobCategoryId', $jobVacancy->jobCategoryId) == $jobCategory->id ? 'selected' : '' }} value="{{ $jobCategory->id }}">{{ $jobCategory->name }}</option>
                            @endforeach
                        </select>
                        @error('jobCategoryId')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Job Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Job Description</label>
                        <textarea rows="4" name="description" id="description"
                            class="{{ $errors->has('description') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $jobVacancy->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-vacancies.index') }}"
                        class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Job Vacancy
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>