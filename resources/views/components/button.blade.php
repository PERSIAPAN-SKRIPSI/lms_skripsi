@props([
    'variant' => 'default', // Ubah default ke 'default'
    'iconOnly' => false,
    'srText' => '',
    'href' => false,
    'size' => 'base',
    'disabled' => false,
    'pill' => false,
    'squared' => false,
    'outlined' => false // Tambah opsi outline
])

@php
    $baseClasses = 'inline-flex items-center transition-colors font-medium select-none disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-offset-2'; // Hapus focus:ring-offset-white

     // Warna dasar (default)
    $defaultClasses = 'bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-gray-500 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-gray-600';

    // Warna untuk varian outline
   $outlineClasses = [
        'primary' => 'text-blue-500 hover:bg-blue-50 focus:ring-blue-500 border border-blue-500',
        'secondary' => 'text-gray-600 hover:bg-gray-100 focus:ring-gray-500 border border-gray-300 dark:text-gray-400 dark:hover:bg-dark-eval-2 dark:focus:ring-gray-500 dark:border-gray-600',
        'success' => 'text-green-500 hover:bg-green-50 focus:ring-green-500 border border-green-500',
        'danger' => 'text-red-500 hover:bg-red-50 focus:ring-red-500 border border-red-500',
        'warning' => 'text-yellow-500 hover:bg-yellow-50 focus:ring-yellow-500 border border-yellow-500',
        'info' => 'text-cyan-500 hover:bg-cyan-50 focus:ring-cyan-500 border border-cyan-500',
        'black' => 'text-black hover:bg-gray-100 focus:ring-black border border-black dark:text-white dark:hover:bg-dark-eval-3 dark:focus:ring-gray-500 dark:border-gray-700',
    ];


    switch ($variant) {
        case 'primary':
            $variantClasses = $outlined ? $outlineClasses['primary'] : 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-500'; // Gunakan blue
            break;
        case 'secondary':
            $variantClasses = $outlined ? $outlineClasses['secondary'] : 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:focus:ring-gray-600';
            break;
        case 'success':
            $variantClasses = $outlined ? $outlineClasses['success'] : 'bg-green-500 text-white hover:bg-green-600 focus:ring-green-500';
            break;
        case 'danger':
            $variantClasses = $outlined ? $outlineClasses['danger'] : 'bg-red-500 text-white hover:bg-red-600 focus:ring-red-500';
            break;
        case 'warning':
            $variantClasses =  $outlined ? $outlineClasses['warning'] : 'bg-yellow-400 text-gray-900 hover:bg-yellow-500 focus:ring-yellow-500'; // Sedikit sesuaikan yellow
            break;
        case 'info':
            $variantClasses = $outlined ? $outlineClasses['info'] : 'bg-cyan-500 text-white hover:bg-cyan-600 focus:ring-cyan-500';
            break;
        case 'black':
            $variantClasses = $outlined ? $outlineClasses['black'] : 'bg-black text-gray-300 hover:text-white hover:bg-gray-800 focus:ring-black dark:hover:bg-dark-eval-3';
            break;
        case 'default':
        default:
            $variantClasses = $defaultClasses; // Gunakan defaultClasses
            break;
    }


    switch ($size) {
        case 'sm':
            $sizeClasses = $iconOnly ? 'p-1.5' : 'px-3 py-1 text-sm';  // Sedikit perbesar padding
            break;
        case 'base':
            $sizeClasses = $iconOnly ? 'p-2' : 'px-4 py-1.5 text-base'; // Sedikit perkecil padding
            break;
        case 'lg':
            $sizeClasses = $iconOnly ? 'p-2.5' : 'px-5 py-2 text-lg'; // Sedikit perkecil padding
            break;
    }

    $classes = $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses;

    if (!$squared && !$pill) {
        $classes .= ' rounded-lg'; // Gunakan rounded-lg
    } elseif ($pill) {
        $classes .= ' rounded-full';
    }

@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
        @if($iconOnly)
            <span class="sr-only">{{ $srText ?? '' }}</span>
        @endif
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
        {{ $slot }}
        @if($iconOnly)
            <span class="sr-only">{{ $srText ?? '' }}</span>
        @endif
    </button>
@endif
