<x-jet-form-section submit="regenerate">
    <x-slot name="title">
        {{ __('Stream Key') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Keep safe this stream key. If you have any doubt about it\'s security, regenerate it.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="streamKey" value="{{ __('Stream Key') }}" />
            <x-jet-input id="streamKey" type="text" class="block w-full mt-1" value="{{$streamKey}}" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="regenerated">
            {{ __('Regenerated.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Regenerate') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
