<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('update this title') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="height:70vh;">
            @livewire('stream.player-and-chat')
        </div>
    </div>
</x-app-layout>


