@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block mt-1 w-full bg-white/10 text-white border-white/10 focus:border-indigo-500 rounded-lg']) }}>