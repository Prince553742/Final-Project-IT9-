@props(['active', 'title' => null])

@php
if ($active) {
    $classes = 'flex items-center w-full py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-500 transition-all duration-200';
} else {
    $classes = 'flex items-center w-full py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg border-l-4 border-transparent transition-all duration-200';
}
@endphp

<a
    {{ $attributes->merge(['class' => $classes]) }}
    x-bind:class="sidebarOpen ? 'px-3 gap-3' : 'justify-center px-0 border-l-0'"
    x-bind:title="!sidebarOpen ? '{{ $title }}' : ''"
>
    {{ $slot }}
</a>