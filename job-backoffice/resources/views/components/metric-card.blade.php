@props([
    'title' => '',
    'value' => '',
    'subtitle' => '',
    // Accept either a named color (e.g. 'indigo') or a full tailwind shade (e.g. 'indigo-600')
    'color' => 'indigo-600',
    // Optional href to make the card clickable
    'href' => null,
    // Optional sparkline data (comma separated numbers or JSON array)
    'sparkline' => null,
    // NEW: Optional icon name (e.g., 'Users', 'Briefcase', 'FileText')
    'icon' => null,
])

@php
    // Map a small set of allowed colors to fixed Tailwind classes.
    // If a full shade is provided (e.g. 'indigo-600'), use it directly.
    if (strpos($color, '-') !== false) {
        $colorClass = 'text-' . $color;
        $bgColorClass = 'bg-' . explode('-', $color)[0] . '-50';
    } else {
        switch ($color) {
            case 'blue':
                $colorClass = 'text-blue-600';
                $bgColorClass = 'bg-blue-50';
                break;
            case 'green':
                $colorClass = 'text-green-600';
                $bgColorClass = 'bg-green-50';
                break;
            case 'red':
                $colorClass = 'text-red-600';
                $bgColorClass = 'bg-red-50';
                break;
            case 'yellow':
                $colorClass = 'text-yellow-600';
                $bgColorClass = 'bg-yellow-50';
                break;
            case 'gray':
                $colorClass = 'text-gray-600';
                $bgColorClass = 'bg-gray-50';
                break;
            case 'indigo':
            default:
                $colorClass = 'text-indigo-600';
                $bgColorClass = 'bg-indigo-50';
                break;
        }
    }

    // Helper function to get Lucide Icon SVG based on name
    $getIconSvg = function ($iconName) {
        return match ($iconName) {
            'Users' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
            'Briefcase' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
            'FileText' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M9 12h6"></path><path d="M9 16h6"></path></svg>',
            default => '',
        };
    };
@endphp

@php
    // Prepare attributes for clickable behavior
    $hasHref = !empty($href) || $attributes->has('data-href');
    $dataHref = $href ?? $attributes->get('data-href');
    $spark = $sparkline ?? $attributes->get('data-sparkline');
    // Ensure spark is string (JSON or comma list)
    if (is_array($spark)) {
        $spark = json_encode($spark);
    }
    $interactiveClasses = $hasHref ? 'cursor-pointer hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2' : '';
    // $ariaRole = $hasHref ? 'role=\"link\" tabindex=\"0\"' : ''; // Removed unnecessary variable definition
@endphp

<div {{ $attributes->merge([ 'class' => "p-5 bg-white border border-gray-100 overflow-hidden shadow-sm rounded-lg {$interactiveClasses} metric-card" ]) }} @if($hasHref) data-href="{{ $dataHref }}" tabindex="0" role="link" @endif>
    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-600">{{ $title }}</h3>
            <p class="mt-2 text-3xl font-bold {{ $colorClass }}">{{ $value }}</p>
        </div>
        
        {{-- Icon Display --}}
        @if ($icon)
            <div class="p-3 rounded-full {{ $bgColorClass }} {{ $colorClass }} shadow-inner">
                {!! $getIconSvg($icon) !!}
            </div>
        @endif
    </div>
    
    @if($subtitle)
        <p class="mt-1 text-xs text-gray-500">{{ $subtitle }}</p>
    @endif

    @if($spark)
        <div class="mt-3 text-xs text-gray-400 sparkline-container {{ str_replace('text-', '', $colorClass) }}" data-sparkline='{{ $spark }}' aria-hidden="true"></div>
    @endif
</div>