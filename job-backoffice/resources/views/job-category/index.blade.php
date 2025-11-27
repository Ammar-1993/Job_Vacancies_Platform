<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-toast-notification />

            <!-- Toolbar -->
            <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-lg shadow-sm border border-gray-100 gap-4">
                
                <!-- Tabs -->
                <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                    <a href="{{ route('job-categories.index') }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ !request('archived') ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        Active
                    </a>
                    <a href="{{ route('job-categories.index', ['archived' => 'true']) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ request('archived') == 'true' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        Archived
                    </a>
                </div>

                <!-- Search & Add -->
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('job-categories.index') }}" class="relative w-full sm:w-64">
                         @if(request('archived'))
                            <input type="hidden" name="archived" value="true">
                        @endif
                         <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                               placeholder="Search category...">
                    </form>

                    <a href="{{ route('job-categories.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Category
                    </a>
                </div>
            </div>

            <!-- Job Category Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category Name</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-3">
                                            @if(request('archived') == 'true')
                                                <form action="{{ route('job-categories.restore', $category->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                        Restore
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('job-categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Archive this category?');">
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
                                    <td colspan="2" class="px-6 py-10 text-center text-gray-500">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>