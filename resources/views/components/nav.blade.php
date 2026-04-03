@props(['active' => false])

@php
$classes = $active
            ? 'flex items-center justify-between px-4 py-3 bg-[#1c1c1c] rounded-xl text-white group transition-all'
            : 'flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-[#151515] rounded-xl transition-all group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($active)
        <div class="flex items-center gap-3">
            {{ $slot }}
        </div>
        <!-- Right Arrow Item -->
        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
        </svg>
    @else
        {{ $slot }}
    @endif
</a>