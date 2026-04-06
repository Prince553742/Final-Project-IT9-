@props(['active'])

@php
$classes = ($active ?? false)
            // Active State: Gradient background, white text, bold, elevated shadow
            ? 'flex items-center px-4 py-3 mb-2 rounded-xl text-sm font-extrabold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white shadow-md shadow-indigo-200 transition-all duration-300'
            // Inactive State: Gray text, gentle hover effect
            : 'flex items-center px-4 py-3 mb-2 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 hover:text-indigo-600 transition-all duration-300 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>