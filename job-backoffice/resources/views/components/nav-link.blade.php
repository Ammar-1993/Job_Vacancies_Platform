@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'flex items-center px-4 py-2 w-full text-sm font-medium text-gray-900 bg-indigo-100 rounded-md focus:outline-none hover:bg-gray-100 focus:bg-gray-200 transition duration-150 ease-in-out'
        : 'flex items-center px-4 py-2 w-full text-sm font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-200 transition duration-150 ease-in-out';
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>