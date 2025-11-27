<nav class="w-[250px] h-screen bg-white border-r border-gray-200">
    <!-- Application logo -->
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 rtl:space-x-reverse">
            <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">Hire Me</span>
        </a>
    </div>

    <!-- Navigation links - Icons Added -->
    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{-- Icon: LayoutDashboard --}}
            <span class="flex items-center space-x-2 rtl:space-x-reverse">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"></rect><rect width="7" height="5" x="14" y="3" rx="1"></rect><rect width="7" height="9" x="14" y="12" rx="1"></rect><rect width="7" height="5" x="3" y="16" rx="1"></rect></svg>
                <span>Dashboard</span>
            </span>
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">
                {{-- Icon: Building --}}
                <span class="flex items-center space-x-2 rtl:space-x-reverse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                    <span>Companies</span>
                </span>
            </x-nav-link>
        @endif

        @if (auth()->user()->role == 'company_owner')
            <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.show')">
                {{-- Icon: Briefcase --}}
                <span class="flex items-center space-x-2 rtl:space-x-reverse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    <span>My Company</span>
                </span>
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.index')">
            {{-- Icon: FileText --}}
            <span class="flex items-center space-x-2 rtl:space-x-reverse">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M9 12h6"></path><path d="M9 16h6"></path></svg>
                <span>Job Applications</span>
            </span>
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.index')">
                {{-- Icon: Tags --}}
                <span class="flex items-center space-x-2 rtl:space-x-reverse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H2v7l10 10 7-7Z"></path><path d="M17.5 7.5V7.5"></path><path d="M13 13L19 7"></path><path d="M15 9l-4 4"></path></svg>
                    <span>Job Categories</span>
                </span>
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.index')">
            {{-- Icon: ClipboardList --}}
            <span class="flex items-center space-x-2 rtl:space-x-reverse">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="M12 11h4"></path><path d="M12 15h4"></path><path d="M8 11h.01"></path><path d="M8 15h.01"></path></svg>
                <span>Job Vacancies</span>
            </span>
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                {{-- Icon: Users --}}
                <span class="flex items-center space-x-2 rtl:space-x-reverse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Users</span>
                </span>
            </x-nav-link>
        @endif

        <hr class="border-gray-100 my-2" />

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-nav-link :href="route('logout')" :active="false" class="text-red-500 hover:bg-red-50 hover:text-red-600 focus:text-red-600">
                <span class="flex items-center space-x-2 rtl:space-x-reverse"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{-- Icon: LogOut --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 group-hover:text-red-600 group-focus:text-red-600"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
                    <span>Logout</span>
                </span>
            </x-nav-link>
        </form>
    </ul>
</nav>