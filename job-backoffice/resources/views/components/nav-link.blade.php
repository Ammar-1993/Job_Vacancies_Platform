@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'flex items-center px-4 py-3 w-full text-sm font-medium text-primary-700 bg-primary-50 border-r-4 border-primary-600 transition duration-150 ease-in-out focus:outline-none'
        : 'flex items-center px-4 py-3 w-full text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition duration-150 ease-in-out focus:outline-none';
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>