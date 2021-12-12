<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-10">
                    <x-jet-welcome />
                    @livewire('home.stream-list')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
