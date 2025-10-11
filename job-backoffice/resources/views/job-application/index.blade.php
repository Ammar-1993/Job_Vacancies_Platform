<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="flex justify-end items-center space-x-4">
            @if(request()->input('archived') == 'true')
                <!-- Active -->
                <a href="{{ route('job-applications.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Active Job Applications
                </a>
            @else
                <!-- Archived -->
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Archived Job Applications
                </a>
            @endif
        </div>


        <!-- Job Vacancy Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Position (Job Vacancy)</th>
                    @if(auth()->user()->role == 'admin')
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobApplications as $jobApplication)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived') == 'true')
                                <span class="text-gray-500">{{ $jobApplication->user->name }}</span>
                            @else
                                <a class="text-blue-500 hover:text-blue-700 underline" href="{{ route('job-applications.show', $jobApplication->id) }}">{{ $jobApplication->user->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy?->title ?? 'N/A' }}</td>
                        @if(auth()->user()->role == 'admin')
                            <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}</td>
                        @endif
                        <td class="px-6 py-4 @if($jobApplication->status == 'accepted') text-green-500 @elseif($jobApplication->status == 'rejected') text-red-500 @else text-purple-500 @endif">{{ $jobApplication->status }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-applications.edit', $jobApplication->id) }}"
                                        class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                    <!-- Archive Button -->
                                    <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST"
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
                        <td colspan="6" class="px-6 py-4 text-gray-800">No job applications found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobApplications->links() }}
        </div>
    </div>
</x-app-layout>