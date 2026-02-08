@props(['title' => null])

<aside {{ $attributes->class(['w-64 shrink-0 border-r bg-white h-full']) }}>
    @if ($title)
        <div class="px-4 py-3 text-sm font-semibold">
            {{ $title }}
        </div>
    @endif

    <nav class="px-2 py-2">
        <ul class="space-y-1">
            {{ $slot }}
        </ul>
    </nav>
</aside>
