<div>
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-2xl font-medium">Live Streams</h2>
        </div>
        <div class="max-w-sm w-full ">
            <div class="flex items-center justify-end">
                <div class="flex items-center">
                    <x-jet-label for="" value="{{ __('Filter by tags:') }}" class="mr-3" />
                </div>
                <div class="relative" x-data="{ isOpen: false }" @click.away="isOpen = false">
                    <x-jet-input x-ref="search" placeholder="Search Tags" @focus="isOpen = true" @keydown="isOpen = true" @keydown.escape.window="isOpen = false" type="text" class="block w-full mt-1" wire:model="tagSearch" />
                    <div class="absolute z-50 w-full mt-2 overflow-y-auto text-sm bg-white border rounded shadow-xl max-h-48" x-show.transition.opacity="isOpen">
                        @if (count($filteredTags) > 0)
                        <ul>
                            @foreach ($filteredTags as $tag)
                            <li class="border-b border-gray-200 last:border-b-0">
                                <button wire:key="tag['id']" wire:click="addTag({{$tag['id']}})" @click="isOpen=false" class="flex justify-center w-full px-3 py-3 hover:bg-gray-100 transition">
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
            <div class="flex flex-wrap justify-end mt-2">
                @foreach ($tags as $tag)
                <x-jet-secondary-button class="mb-2 mr-2" wire:click="removeTag({{ $tag['id']}})">{{ $tag['name']}} (x)</x-jet-secondary-button>
                @endforeach
            </div>

        </div>

    </div>

    @if(count($streams) == 0)
    <h3 class="text-3xl font-medium text-center my-20">No live-stream found</h3>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        @foreach($streams as $stream)
        <a href="{{ route('stream.watch', $stream['owner']['username'])}}">
            <div class="px-4 py-4 mt-4 bg-white rounded-lg shadow-md border" wire:click="goToStream($stream['owner']['username'])">
                <div class="flex flex-col pb-2 mb-2 border-b border-gray-100 lg:items-start lg:justify-between lg:flex-row">
                    <div>
                        <h2 class="text-xl font-medium" id="stream-title">{{strlen($stream['title']) > 0 ? $stream['title'] : "Stream of: " . $stream['owner']['username']}}</h2>
                        <h2 class="font-medium text-md" id="stream-description">{{$stream['description']}}</h2>
                    </div>
                </div>
                <div class="flex items-center py-2 mr-4 overflow-hidden lg:py-0">
                    <img src="{{ $stream['owner']['profile_photo_url']}}" class="w-12 h-12 mr-2 rounded-full shadow-sm">
                    <p class="text-md font-medium">{{ '@'.$stream['owner']['username'] }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
