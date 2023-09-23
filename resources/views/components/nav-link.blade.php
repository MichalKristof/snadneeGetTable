@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 rounded-2xl border-2 border-indigo-800 text-sm font-medium text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 rounded-2xl border-2 border-transparent text-sm font-medium text-gray-300 hover:text-gray-100 hover:border-indigo-400 focus:outline-none focus:text-gray-800 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
