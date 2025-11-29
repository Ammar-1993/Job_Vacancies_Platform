@props([
    'value' => null,
    'label' => null,
])

@php
    // Determine display text and color based on numeric value if provided.
    $text = $label ?? $value;
    $colorClass = 'bg-gray-100 text-gray-800';

    if (is_numeric($value)) {
        $v = (float) $value;
        if ($v >= 50) {
            $colorClass = 'bg-green-100 text-green-800';
        } elseif ($v >= 20) {
            $colorClass = 'bg-yellow-100 text-yellow-800';
        } else {
            $colorClass = 'bg-red-100 text-red-800';
        }
        $text = $text . '%';
    }
@endphp

<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">{{ $text }}</span>
