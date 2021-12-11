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


            <div class="col-span-6 sm:col-span-4">

            <x-jet-label for="" value="{{ __('Stream Tags (Click To Remove)') }}" class="mb-3"/>
            <div>
                @foreach ($tags as $tag)
                    <x-jet-secondary-button class="mb-2 mr-2" wire:click="removeTag({{ $tag['id']}})">{{ $tag['name']}} (x)</x-jet-secondary-button>
                @endforeach
            </div>

            <div class="relative" x-data="{ isOpen: false }" @click.away="isOpen = false">
                <x-jet-input x-ref="search" placeholder="Search Tags" @focus="isOpen = true" @keydown="isOpen = true" @keydown.escape.window="isOpen = false" type="text" class="block w-full mt-1" wire:model="tagSearch" />
                    <div
                        class="absolute z-50 w-full mt-2 overflow-y-auto text-sm bg-white border rounded shadow-xl max-h-48"
                        x-show.transition.opacity="isOpen"
                    >
                        @if (count($filteredTags) > 0)
                            <ul>
                                @foreach ($filteredTags as $tag)
                                    <li class="border-b border-gray-200 last:border-b-0">
                                        <button wire:key="tag['id']" wire:click="addTag({{$tag['id']}})" class="flex justify-center w-full px-3 py-3 hover:bg-gray-100 transition" >
                                            <span class="mx-4">{{ $tag['name'] }}</span>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="w-full px-2 py-2 text-center">No results for "{{ $tagSearch }}"</div>
                        @endif
                    </div>
            </div>

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
