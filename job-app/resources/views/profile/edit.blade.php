<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white leading-tight">
            {{ __('app.profile.settings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Update Profile Information Card -->
            <div class="p-4 sm:p-8 bg-gray-800 shadow-lg rounded-xl border border-indigo-700/30 text-white shadow-indigo-500/10">
                <div class="max-w-xl">
                    <!-- The partials should now inherit text-white for better visibility. -->
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-4 sm:p-8 bg-gray-800 shadow-lg rounded-xl border border-indigo-700/30 text-white shadow-indigo-500/10">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Card -->
            <div class="p-4 sm:p-8 bg-gray-800 shadow-lg rounded-xl border border-indigo-700/30 text-white shadow-indigo-500/10">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>