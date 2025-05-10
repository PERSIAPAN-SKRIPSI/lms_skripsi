@props(['active' => false, 'title' => '', 'isActive' => false])

@php
    // Use either 'active' or 'isActive' prop for backward compatibility
    $isItemActive = $active || $isActive;
@endphp

<div class="relative" x-data="{ open: @json($isItemActive) }">
    <x-sidebar.link
        collapsible
        title="{{ $title }}"
        @click="open = !open"
        :isActive="$isItemActive"
    >
        @if ($icon ?? false)
        <x-slot name="icon">
            {{ $icon }}
        </x-slot>
        @endif
    </x-sidebar.link>

    <div
        x-show="open && (isSidebarOpen || isSidebarHovered)"
        x-collapse
        x-cloak
        class="transition-all duration-300 ease-in-out"
    >
        <ul
            class="relative px-0 pt-2 pb-0 ml-5 before:w-0 before:block before:absolute before:inset-y-0 before:left-0 before:border-l-2 before:border-l-gray-200 dark:before:border-l-gray-600">
            {{ $slot }}
        </ul>
    </div>
</div>
