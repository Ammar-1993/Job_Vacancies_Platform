@props([
    'icon' => 'briefcase',
    'title' => 'No Data Found',
    'description' => '',
    'actionText' => null,
    'actionUrl' => null,
])

@php
    $iconSvgs = [
        'briefcase' => '<svg viewBox="0 0 200 200" class="w-48 h-48 mx-auto text-gray-200"><rect x="40" y="80" width="120" height="80" rx="12" stroke="currentColor" stroke-width="3" fill="none"/><path d="M70 80 L70 60 Q70 50 80 50 L120 50 Q130 50 130 60 L130 80" stroke="currentColor" stroke-width="3" fill="none"/><line x1="40" y1="110" x2="160" y2="110" stroke="currentColor" stroke-width="3"/><circle cx="100" cy="130" r="8" fill="currentColor" class="text-primary-400"/></svg>',
        
        'clipboard' => '<svg viewBox="0 0 200 200" class="w-48 h-48 mx-auto text-gray-200"><rect x="50" y="40" width="100" height="130" rx="8" stroke="currentColor" stroke-width="3" fill="none"/><rect x="70" y="30" width="60" height="20" rx="4" fill="currentColor"/><line x1="70" y1="70" x2="130" y2="70" stroke="currentColor" stroke-width="3" stroke-linecap="round"/><line x1="70" y1="90" x2="130" y2="90" stroke="currentColor" stroke-width="3" stroke-linecap="round"/><line x1="70" y1="110" x2="110" y2="110" stroke="currentColor" stroke-width="3" stroke-linecap="round"/><circle cx="100" cy="140" r="12" fill="currentColor" class="text-primary-400"/></svg>',
        
        'building' => '<svg viewBox="0 0 200 200" class="w-48 h-48 mx-auto text-gray-200"><rect x="50" y="40" width="100" height="120" rx="8" stroke="currentColor" stroke-width="3" fill="none"/><rect x="75" y="140" width="50" height="20" fill="currentColor"/><rect x="70" y="60" width="20" height="20" rx="4" stroke="currentColor" stroke-width="2" fill="none"/><rect x="110" y="60" width="20" height="20" rx="4" stroke="currentColor" stroke-width="2" fill="none"/><rect x="70" y="90" width="20" height="20" rx="4" fill="currentColor" class="text-primary-400"/><rect x="110" y="90" width="20" height="20" rx="4" stroke="currentColor" stroke-width="2" fill="none"/><rect x="70" y="120" width="20" height="20" rx="4" stroke="currentColor" stroke-width="2" fill="none"/><rect x="110" y="120" width="20" height="20" rx="4" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        
        'folder' => '<svg viewBox="0 0 200 200" class="w-48 h-48 mx-auto text-gray-200"><path d="M40 70 L40 150 Q40 160 50 160 L150 160 Q160 160 160 150 L160 70 Z" stroke="currentColor" stroke-width="3" fill="none"/><path d="M40 70 L70 70 L85 55 L110 55 L125 70 L160 70" stroke="currentColor" stroke-width="3" fill="none"/><rect x="80" y="100" width="40" height="30" rx="6" fill="currentColor" class="text-primary-400"/></svg>',
        
        'users' => '<svg viewBox="0 0 200 200" class="w-48 h-48 mx-auto text-gray-200"><circle cx="100" cy="70" r="25" stroke="currentColor" stroke-width="3" fill="none"/><path d="M60 140 Q60 110 100 110 Q140 110 140 140 L140 160 L60 160 Z" stroke="currentColor" stroke-width="3" fill="none"/><circle cx="60" cy="80" r="18" stroke="currentColor" stroke-width="2.5" fill="none"/><path d="M30 135 Q30 115 60 115" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/><circle cx="140" cy="80" r="18" fill="currentColor" class="text-primary-400"/><path d="M140 115 Q170 115 170 135" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/></svg>',
    ];
    
    $iconSvg = $iconSvgs[$icon] ?? $iconSvgs['briefcase'];
@endphp

<div class="flex flex-col items-center justify-center py-16 px-4 text-center">
    <!-- SVG Illustration -->
    <div class="mb-8">
        {!! $iconSvg !!}
    </div>
    
    <!-- Title -->
    <h3 class="text-2xl font-bold text-gray-900 mb-3">
        {{ $title }}
    </h3>
    
    <!-- Description -->
    @if($description)
        <p class="text-base text-gray-500 max-w-md mb-8">
            {{ $description }}
        </p>
    @endif
    
    <!-- Action Button -->
    @if($actionText && $actionUrl)
        <a href="{{ $actionUrl }}" 
           class="inline-flex items-center px-6 py-3 bg-primary-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 shadow-sm hover:shadow-md transition-all duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            {{ $actionText }}
        </a>
    @endif
</div>
