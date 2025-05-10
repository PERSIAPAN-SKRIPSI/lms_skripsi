@props(['isActive' => false, 'title' => ''])

@php
    $baseClasses = 'flex items-center px-4 py-2 text-sm ml-6 rounded-md transition-colors';

    // Active state uses the same blue colors as the parent link
    $activeClasses = $isActive
        ? 'text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800 shadow-md'
        : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-dark-eval-2';

    $classes = $baseClasses . ' ' . $activeClasses;
@endphp

<a
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $title }}
</a>
