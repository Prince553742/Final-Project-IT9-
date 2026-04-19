@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-500 transition-all duration-200'
    : 'flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>