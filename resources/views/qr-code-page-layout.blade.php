<x-filament-panels::layout.base :livewire="$livewire">
    <div
        class="fi-layout flex min-h-screen w-full flex-row-reverse overflow-x-clip"
    >
        <main
            class="fi-main mx-auto h-full w-full px-4 md:px-6 lg:px-8 max-w-6xl"
        >

            {{ $slot }}

        </main>
    </div>
</x-filament-panels::layout.base>
