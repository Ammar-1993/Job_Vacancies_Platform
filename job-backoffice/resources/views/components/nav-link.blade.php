@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'flex items-center px-4 py-2 w-full text-sm font-medium text-gray-900 bg-indigo-100 rounded-md hover:bg-gray-100 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2'
        : 'flex items-center px-4 py-2 w-full text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2';
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>