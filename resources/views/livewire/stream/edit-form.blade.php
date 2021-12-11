<div class="mx-auto max-w-7xl">
    <x-jet-form-section submit="update">
        <x-slot name="title">
            {{ __('Stream Settings') }}
        </x-slot>

        <x-slot name="description">
            {{ __('This form is visible just for you.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="title" value="{{ __('Stream Title') }}" />
                <x-jet-input id="title" type="text" class="block w-full mt-1" wire:model.lazy="title" />
                <x-jet-input-error for="title" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="description" value="{{ __('Stream Description') }}" />
                <x-jet-input id="description" type="text" class="block w-full mt-1" wire:model.lazy="description" />
                <x-jet-input-error for="description" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="regenerated">
                {{ __('Updated.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Update') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
