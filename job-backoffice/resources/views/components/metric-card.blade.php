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
])

@php
    // Map a small set of allowed colors to fixed Tailwind classes.
    // If a full shade is provided (e.g. 'indigo-600'), use it directly.
    if (strpos($color, '-') !== false) {
        $colorClass = 'text-' . $color;
    } else {
        switch ($color) {
            case 'blue':
                $colorClass = 'text-blue-600';
                break;
            case 'green':
                $colorClass = 'text-green-600';
                break;
            case 'red':
                $colorClass = 'text-red-600';
                break;
            case 'yellow':
                $colorClass = 'text-yellow-600';
                break;
            case 'gray':
                $colorClass = 'text-gray-600';
                break;
            case 'indigo':
            default:
                $colorClass = 'text-indigo-600';
                break;
        }
    }
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
    $interactiveClasses = $hasHref ? 'cursor-pointer hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2' : '';
    $ariaRole = $hasHref ? 'role=\"link\" tabindex=\"0\"' : '';
@endphp

<div {{ $attributes->merge([ 'class' => "p-4 bg-white border border-gray-100 overflow-hidden shadow-sm rounded-lg {$interactiveClasses} metric-card" ]) }} @if($hasHref) data-href="{{ $dataHref }}" tabindex="0" role="link" @endif>
    <h3 class="text-sm font-medium text-gray-600">{{ $title }}</h3>
    <p class="mt-2 text-3xl font-bold {{ $colorClass }}">{{ $value }}</p>
    @if($subtitle)
        <p class="mt-1 text-xs text-gray-500">{{ $subtitle }}</p>
    @endif

    @if($spark)
        <div class="mt-3 text-xs text-gray-400 sparkline-container {{ str_replace('text-', '', $colorClass) }}" data-sparkline='{{ $spark }}' aria-hidden="true"></div>
    @endif
</div>
