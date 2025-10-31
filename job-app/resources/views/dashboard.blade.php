{{--
    Dashboard view (resources/views/dashboard.blade.php)

    Purpose/Contract:
    - Renders a paginated list of job vacancies for the authenticated user.
    - Expects a paginated collection in the `$jobs` variable (LengthAwarePaginator / Collection)
    - Reads query parameters: `search` (string) and `filter` (one of: Full-Time, Remote, Hybrid, Contract)
    - Uses the `x-app-layout` Blade component (Breeze/Jetstream-style) and Tailwind CSS for styling.

    Key behaviors to be aware of:
    - The search form submits GET to `route('dashboard')` and preserves `filter` when present.
    - Filter links append `filter` and preserve `search` when present.
    - When no jobs are returned the view shows a prominent "No jobs found!" message.
    - Pagination is rendered via `$jobs->links()`; controller should provide a paginator.

    Important variables and relationships used in this view:
    - `Auth::user()->name` — authenticated user display name.
    - `$job->title`, `$job->company->name`, `$job->location`, `$job->salary`, `$job->type` — job model properties.

    Notes for maintainers/agents:
    - Keep comments in Blade format ({{-- ... --}}) to avoid sending extra output to the browser.
    - This view relies on Tailwind classes for visual appearance; rearranging markup can affect layout.
    - Routes referenced: `dashboard` and `job-vacancies.show` (show expects a job id).
-->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Main page container: spacing and centered max-width card. --}}
    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">
            {{-- Greeting: localized and showing authenticated user's name. --}}
            <h3 class="text-white text-2xl font-bold mb-6">
                {{ __('Welcome back,') }} {{ Auth::user()->name }}!
            </h3>

            {{-- Search & Filters
                - Search form is a GET to the dashboard route and preserves `filter` via a hidden input
                - Filter links preserve the current `search` query so the two can be combined
            -->
            <div class="flex items-center justify-between">
                <!-- Search Bar -->
                <form action="{{ route('dashboard') }}" method="get" class="flex items-center justify-center w-1/4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full p-2 rounded-l-lg bg-gray-800 text-white" placeholder="Search for a job">
                    <button type="submit"
                        class="bg-indigo-500 text-white p-2 rounded-r-lg border border-indigo-500">Search</button>

                    {{-- If a filter is active, keep it when submitting the search form so results combine both. --}}
                    @if (request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif

                    @if (request('search'))
                        <a href="{{ route('dashboard', ['filter' => request('filter')]) }}"
                            class=" text-white p-2 rounded-lg ml-2">Clear</a>
                    @endif
                </form>

                {{-- Quick filter links: these navigate to dashboard with the selected `filter` and keep `search`. --}}
                <!-- Filters -->
                <div class="flex space-x-2">
                    <a href="{{ route('dashboard', ['filter' => 'Full-Time', 'search' => request('search')]) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Full-Time</a>
                    <a href="{{ route('dashboard', ['filter' => 'Remote', 'search' => request('search')]) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Remote</a>
                    <a href="{{ route('dashboard', ['filter' => 'Hybrid', 'search' => request('search')]) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Hybrid</a>
                    <a href="{{ route('dashboard', ['filter' => 'Contract', 'search' => request('search')]) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Contract</a>

                    {{-- Show a clear-filter link when a filter is active. It keeps the current search term (if any). --}}
                    @if (request('filter'))
                        <a href="{{ route('dashboard', ['search' => request('search')]) }}"
                            class=" text-white p-2 rounded-lg">Clear</a>
                    @endif
                </div>
            </div>

            {{-- Job list:
                - Loops through `$jobs`. Each `$job` is expected to have a `company` relation.
                - Shows title (linked), company name, location, salary (formatted) and job type badge.
                - Uses `@forelse` so an empty-state message is shown when there are no results.
                - Pagination must be provided by the controller via a paginator (e.g., ->paginate()).
            --}}
            <div class="space-y-4 mt-6">
                @forelse ($jobs as $job)
                    {{-- Job Item --}}
                    <div class="border-b border-white/10 pb-4 flex justify-between items-center">
                        <div>
                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                class="text-lg font-semibold text-blue-400 hover:underline">{{ $job->title }}</a>
                            <p class="text-sm text-white">{{ $job->company->name }} - {{ $job->location }}</p>
                            <p class="text-sm text-white">{{ '$' . number_format($job->salary) }} / Year</p>
                        </div>
                        <span class="bg-blue-500 text-white p-2 rounded-lg">{{ $job->type }}</span>
                    </div>
                @empty
                    {{-- Empty state --}}
                    <p class="text-white text-2xl font-bold">No jobs found!</p>
                @endforelse
            </div>
            {{-- Pagination links (Tailwind-styled by the paginator) --}}
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>