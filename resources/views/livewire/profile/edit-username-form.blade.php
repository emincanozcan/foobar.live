<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Update Username') }}
    </x-slot>

    <x-slot name="description">
        {{ __('If you update your username, the live stream url change too.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="username" value="{{ __('Current Username') }}" />
            <x-jet-input id="username" type="text" class="block w-full mt-1" wire:model.defer="username" autocomplete="username" />
            <x-jet-input-error for="username" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
