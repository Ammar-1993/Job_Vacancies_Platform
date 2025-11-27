<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-toast-notification />

            <!-- Toolbar -->
            <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-lg shadow-sm border border-gray-100 gap-4">
                
                <!-- Tabs -->
                <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                    <a href="{{ route('job-applications.index') }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ !request('archived') ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        Active
                    </a>
                    <a href="{{ route('job-applications.index', ['archived' => 'true']) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ request('archived') == 'true' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        Archived
                    </a>
                </div>

                <!-- Search & Filters -->
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('job-applications.index') }}" class="flex gap-2 w-full sm:w-auto">
                        @if(request('archived'))
                            <input type="hidden" name="archived" value="true">
                        @endif
                        
                        <!-- Status Filter -->
                        <select name="status" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-600">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>

                        <!-- Search Input -->
                        <div class="relative">
                             <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-9 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="Search...">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Applications Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position & Company</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($jobApplications as $jobApplication)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        @php $applicant = $jobApplication->user; @endphp
                                        <div class="flex items-center">
                                            @if($applicant)
                                                <div class="h-8 w-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-xs mr-3">
                                                    {{ substr($applicant->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    @if(request('archived') != 'true')
                                                        <a href="{{ route('job-applications.show', $jobApplication->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 hover:underline">
                                                            {{ $applicant->name }}
                                                        </a>
                                                    @else
                                                        <span class="text-sm font-medium text-gray-900">{{ $applicant->name }}</span>
                                                    @endif
                                                    <div class="text-xs text-gray-500">{{ $applicant->email }}</div>
                                                </div>
                                            @else
                                                 <span class="text-sm text-gray-500 italic">Unknown Applicant</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">{{ $jobApplication->jobVacancy?->title ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'accepted' => 'bg-green-100 text-green-800 border-green-200',
                                                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                                'pending'  => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            ];
                                            $colorClass = $statusColors[$jobApplication->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="px-2.5 py-0.5 inline-flex text-xs font-medium border rounded-full {{ $colorClass }} capitalize">
                                            {{ $jobApplication->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-3">
                                            @if(request('archived') == 'true')
                                                <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                        Restore
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('job-applications.edit', $jobApplication->id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST" onsubmit="return confirm('Archive this application?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 flex items-center ml-2">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                                        Archive
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        <p>No job applications found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($jobApplications->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $jobApplications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>