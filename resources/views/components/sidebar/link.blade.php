@props(['isActive' => false, 'title' => '', 'collapsible' => false])

@php
    $baseClasses = 'flex-shrink-0 flex items-center gap-2 p-2 transition-colors rounded-md overflow-hidden group'; // Added 'group' for easier hover styling in dark mode
     // Classes for the active state
     $isActiveClasses = $isActive
        ? 'text-white bg-blue-500 shadow-lg hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800 dark:shadow-blue-500/50' // Blue Serenity active state
        : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-dark-eval-2'; // Blue Serenity inactive state

    $classes = $baseClasses . ' ' . $isActiveClasses;

    if($collapsible) $classes .= ' w-full';
@endphp

@if ($collapsible)
    <button type="button" {{ $attributes->merge(['class' => $classes]) }} >
        @if ($icon ?? false)
            {{ $icon }}
        @else
            <x-icons.empty-circle class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors" aria-hidden="true" /> {{-- Dark mode icon color --}}
        @endif

        <span class="text-base font-medium whitespace-nowrap" x-show="isSidebarOpen || isSidebarHovered">
            {{ $title }}
        </span>

        <span  x-show="isSidebarOpen || isSidebarHovered" aria-hidden="true" class="relative block ml-auto w-6 h-6">
            <span :class="open ? '-rotate-45' : 'rotate-45'" class="absolute right-[9px] bg-gray-400 dark:bg-gray-500 mt-[-5px] h-2 w-[2px] top-1/2 transition-all duration-200"></span> {{-- Dark mode accordion icon color --}}
            <span :class="open ? 'rotate-45' : '-rotate-45'" class="absolute left-[9px] bg-gray-400 dark:bg-gray-500 mt-[-5px] h-2 w-[2px] top-1/2 transition-all duration-200"></span> {{-- Dark mode accordion icon color --}}
        </span>
    </button>
@else
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon ?? false)
            {{ $icon }}
        @else
            <x-icons.empty-circle class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors" aria-hidden="true" /> {{-- Dark mode icon color --}}
        @endif

        <span class="text-base font-medium" x-show="isSidebarOpen || isSidebarHovered">
            {{ $title }}
        </span>
    </a>
@endif
