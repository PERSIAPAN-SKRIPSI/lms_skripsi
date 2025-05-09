<div class="flex items-center justify-between flex-shrink-0 px-4"> <!-- More padding -->
    <!-- Logo -->
    <a href="{{ route('frontend.index') }}" class="inline-flex items-center gap-2">
        <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="logo" class="w-auto h-8"/>  <!-- Responsive logo sizing -->
        <span class="sr-only">K UI Logo</span>
    </a>

    <!-- Toggle button -->
    <x-button
        type="button"
        iconOnly
        srText="Toggle sidebar"
        variant="secondary"
        @click="isSidebarOpen = !isSidebarOpen"
    >
        <template x-if="isSidebarOpen">
            <x-icons.menu-fold-left aria-hidden="true" class="w-6 h-6" />
        </template>
        <template x-if="!isSidebarOpen">
            <x-icons.menu-fold-right aria-hidden="true" class="w-6 h-6" />
        </template>
    </x-button>
</div>
