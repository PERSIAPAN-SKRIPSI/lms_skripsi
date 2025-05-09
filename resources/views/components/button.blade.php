@props([
    'variant' => 'default',
    'iconOnly' => false,
    'srText' => '',
    'href' => false,
    'size' => 'base',
    'disabled' => false,
    'pill' => false,
    'squared' => false,
    'outlined' => false,
    'flat' => false,
    'loading' => false,
    'icon' => false,
    'iconPosition' => 'left',
    'shadow' => false
])

@php
    $baseClasses = 'inline-flex items-center justify-center transition-all duration-200 font-medium select-none disabled:opacity-60 disabled:cursor-not-allowed focus:outline-none gap-x-2';

    // Base color variants
    if ($outlined) {
        $variants = [
            'primary' => 'text-blue-600 border border-blue-600 hover:bg-blue-50 focus:ring-2 focus:ring-blue-500/50 dark:text-blue-400 dark:border-blue-400 dark:hover:bg-blue-950',
            'secondary' => 'text-gray-600 border border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-gray-400/50 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-800',
            'success' => 'text-emerald-600 border border-emerald-600 hover:bg-emerald-50 focus:ring-2 focus:ring-emerald-500/50 dark:text-emerald-400 dark:border-emerald-400 dark:hover:bg-emerald-950',
            'danger' => 'text-red-600 border border-red-600 hover:bg-red-50 focus:ring-2 focus:ring-red-500/50 dark:text-red-400 dark:border-red-400 dark:hover:bg-red-950',
            'warning' => 'text-amber-600 border border-amber-600 hover:bg-amber-50 focus:ring-2 focus:ring-amber-500/50 dark:text-amber-400 dark:border-amber-400 dark:hover:bg-amber-950',
            'info' => 'text-sky-600 border border-sky-600 hover:bg-sky-50 focus:ring-2 focus:ring-sky-500/50 dark:text-sky-400 dark:border-sky-400 dark:hover:bg-sky-950',
            'default' => 'text-gray-600 border border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-gray-400/50 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-800',
        ];
    } elseif ($flat) {
        $variants = [
            'primary' => 'text-blue-600 hover:bg-blue-50 focus:ring-2 focus:ring-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-950',
            'secondary' => 'text-gray-600 hover:bg-gray-50 focus:ring-2 focus:ring-gray-400/20 dark:text-gray-300 dark:hover:bg-gray-800',
            'success' => 'text-emerald-600 hover:bg-emerald-50 focus:ring-2 focus:ring-emerald-500/20 dark:text-emerald-400 dark:hover:bg-emerald-950',
            'danger' => 'text-red-600 hover:bg-red-50 focus:ring-2 focus:ring-red-500/20 dark:text-red-400 dark:hover:bg-red-950',
            'warning' => 'text-amber-600 hover:bg-amber-50 focus:ring-2 focus:ring-amber-500/20 dark:text-amber-400 dark:hover:bg-amber-950',
            'info' => 'text-sky-600 hover:bg-sky-50 focus:ring-2 focus:ring-sky-500/20 dark:text-sky-400 dark:hover:bg-sky-950',
            'default' => 'text-gray-600 hover:bg-gray-50 focus:ring-2 focus:ring-gray-400/20 dark:text-gray-300 dark:hover:bg-gray-800',
        ];
    } else {
        $variants = [
            'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/50 dark:bg-blue-600 dark:hover:bg-blue-700',
            'secondary' => 'bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-2 focus:ring-gray-400/50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600',
            'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500/50 dark:bg-emerald-600 dark:hover:bg-emerald-700',
            'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500/50 dark:bg-red-600 dark:hover:bg-red-700',
            'warning' => 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-2 focus:ring-amber-500/50 dark:bg-amber-600 dark:hover:bg-amber-700',
            'info' => 'bg-sky-600 text-white hover:bg-sky-700 focus:ring-2 focus:ring-sky-500/50 dark:bg-sky-600 dark:hover:bg-sky-700',
            'default' => 'bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-2 focus:ring-gray-400/50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600',
        ];
    }

    $variantClasses = $variants[$variant] ?? $variants['default'];

    // Sizes
    $sizes = [
        'xs' => $iconOnly ? 'p-1.5 text-xs' : 'px-2.5 py-1.5 text-xs',
        'sm' => $iconOnly ? 'p-2 text-sm' : 'px-3 py-1.5 text-sm',
        'base' => $iconOnly ? 'p-2.5' : 'px-4 py-2 text-sm',
        'lg' => $iconOnly ? 'p-3' : 'px-5 py-2.5 text-base',
        'xl' => $iconOnly ? 'p-3.5' : 'px-6 py-3 text-base',
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['base'];

    // Shape
    if ($pill) {
        $shapeClass = 'rounded-full';
    } elseif ($squared) {
        $shapeClass = 'rounded-none';
    } else {
        $shapeClass = 'rounded-md';
    }

    // Shadow
    $shadowClass = $shadow ? 'shadow-md hover:shadow-lg' : '';

    // Loading state
    $loadingClass = $loading ? 'relative !text-transparent' : '';

    $classes = $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses . ' ' . $shapeClass . ' ' . $shadowClass . ' ' . $loadingClass;
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <span class="absolute inset-0 flex items-center justify-center">
                <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        @endif

        @if($icon && $iconPosition === 'left' && !$iconOnly)
            <span class="shrink-0">{{ $icon }}</span>
        @endif

        @if(!$iconOnly)
            <span>{{ $slot }}</span>
        @else
            {{ $slot }}
            <span class="sr-only">{{ $srText ?? '' }}</span>
        @endif

        @if($icon && $iconPosition === 'right' && !$iconOnly)
            <span class="shrink-0">{{ $icon }}</span>
        @endif
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes, 'disabled' => $disabled || $loading]) }}>
        @if($loading)
            <span class="absolute inset-0 flex items-center justify-center">
                <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        @endif

        @if($icon && $iconPosition === 'left' && !$iconOnly)
            <span class="shrink-0">{{ $icon }}</span>
        @endif

        @if(!$iconOnly)
            <span>{{ $slot }}</span>
        @else
            {{ $slot }}
            <span class="sr-only">{{ $srText ?? '' }}</span>
        @endif

        @if($icon && $iconPosition === 'right' && !$iconOnly)
            <span class="shrink-0">{{ $icon }}</span>
        @endif
    </button>
@endif
