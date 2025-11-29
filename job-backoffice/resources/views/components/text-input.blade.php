@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm transition-colors duration-150']) }}>
