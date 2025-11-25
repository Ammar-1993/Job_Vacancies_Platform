@props([
    'title' => '',
    'value' => '',
    'subtitle' => '',
    // Accept either a named color (e.g. 'indigo') or a full tailwind shade (e.g. 'indigo-600')
    'color' => 'indigo-600',
])

@php
    // Map a small set of allowed named colors to fixed Tailwind classes.
    // If a full shade is provided (e.g. 'indigo-600'), use it directly as 'text-indig-600'.
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

<div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
    <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
    <p class="text-3xl font-bold {{ $colorClass }}">{{ $value }}</p>
    @if($subtitle)
        <p class="text-sm text-gray-500">{{ $subtitle }}</p>
    @endif
</div>
