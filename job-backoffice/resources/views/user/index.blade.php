<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="flex justify-end items-center space-x-4">
            @if(request()->input('archived') == 'true')
                <!-- Active -->
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Active Users
                </a>
            @else
                <!-- Archived -->
                <a href="{{ route('users.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Archived Users
                </a>
            @endif
        </div>


        <!-- Job Vacancy Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr @if(request()->input('archived') != 'true' && $user->role != 'admin') data-href="{{ route('users.edit', $user->id) }}" tabindex="0" role="link" aria-label="Edit user {{ $user->name }}" @endif class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-800 truncate max-w-lg">
                            <span class="text-gray-700">{{ $user->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-800 truncate">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $user->role }}</td>
                        <td>
                            <div class="flex items-center space-x-4">
                                @if(request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800 text-sm">🔄 Restore</button>
                                    </form>
                                @else
                                    <!-- If Admin don't allow edit or delete -->
                                    @if($user->role != 'admin')
                                        <!-- Edit Button -->
                                        <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">✍️ Edit</a>

                                        <!-- Archive Button -->
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">🗃️ Archive</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-gray-800">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>