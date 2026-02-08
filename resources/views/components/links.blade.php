@props([
    'href' => '#',
])

@php
    $active = request()->fullUrlIs(url($href)) || request()->is(ltrim($href, '/') . '*');
@endphp

<li>
    <a href="{{ $href }}"
        {{ $attributes->class([
            'group flex items-center gap-2 rounded-md px-3 py-2 text-sm transition',
            'bg-gray-100 font-medium text-gray-900' => $active,
            'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !$active,
        ]) }}>
        <span class="flex-1">{{ $slot }}</span>
    </a>
</li>
