<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-primary-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 shadow-sm hover:shadow-md transition-all duration-150']) }}>
    {{ $slot }}
</button>
