@props(['type'])

@php
    $colors = [
        'purple' => 'bg-purple-100 text-purple-800',
        'orange' => 'bg-orange-100 text-orange-800',
    ];
    $colorClass = $colors[$type->color()] ?? $colors['purple'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$colorClass}"]) }}>
    {{ $type->label() }}
</span>
