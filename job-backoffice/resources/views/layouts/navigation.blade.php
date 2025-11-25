<nav class="w-[250px] h-screen bg-white border-r border-gray-200">
    <!-- Application logo -->
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">Shaghalni</span>
        </a>
    </div>

    <!-- Navigation links -->
    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">
                Companies
            </x-nav-link>
        @endif

        @if (auth()->user()->role == 'company-owner')
            <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.show')">
                My Company
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.index')">
            Job Applications
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.index')">
                Job Categories
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.index')">
            Job Vacancies
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                Users
            </x-nav-link>
        @endif

        <hr />

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-nav-link :href="route('logout')" :active="false" class="text-red-500"
                onclick="event.preventDefault(); this.closest('form').submit();">
                Logout
            </x-nav-link>
        </form>
    </ul>
</nav>