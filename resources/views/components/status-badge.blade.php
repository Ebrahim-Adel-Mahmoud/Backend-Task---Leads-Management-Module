@props(['status'])

@php
    $colors = [
        'gray' => 'bg-gray-100 text-gray-800',
        'blue' => 'bg-blue-100 text-blue-800',
        'green' => 'bg-green-100 text-green-800',
        'red' => 'bg-red-100 text-red-800',
    ];
    $colorClass = $colors[$status->color()] ?? $colors['gray'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$colorClass}"]) }}>
    {{ $status->label() }}
</span>
