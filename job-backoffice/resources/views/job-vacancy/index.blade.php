<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancies') }} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="flex justify-end items-center space-x-4">
            @if(request()->input('archived') == 'true')
                <!-- Active -->
                <a href="{{ route('job-vacancies.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Active Job Vacancies
                </a>
            @else
                <!-- Archived -->
                <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Archived Job Vacancies
                </a>
            @endif

            <!-- Add Company Button -->
            <a href="{{ route('job-vacancies.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Add Job Vacancy
            </a>
        </div>


        <!-- Job Vacancy Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                    @if(auth()->user()->role == 'admin')
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobVacancies as $jobVacancy)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived') == 'true')
                                <span class="text-gray-500">{{ $jobVacancy->title }}</span>
                            @else
                                <a class="text-blue-500 hover:text-blue-700 underline" href="{{ route('job-vacancies.show', $jobVacancy->id) }}">{{ $jobVacancy->title }}</a>
                            @endif
                        </td>
                        @if(auth()->user()->role == 'admin')
                            <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->company->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->location }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->type }}</td>
                        <td class="px-6 py-4 text-gray-800">${{number_format($jobVacancy->salary, 2)  }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-vacancies.restore', $jobVacancy->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-vacancies.edit', $jobVacancy->id) }}"
                                        class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                    <!-- Archive Button -->
                                    <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-gray-800">No job vacancies found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>
    </div>
</x-app-layout>