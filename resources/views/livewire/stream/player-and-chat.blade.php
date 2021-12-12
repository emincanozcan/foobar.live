<div @unless($stream) wire:poll="fillStreamData" @endunless style="min-height: 100%;">
    <style>
    @media (min-width: 1024px){ 
        #player-and-chat {  } 
        #my-player {
            width: max(calc(80vh - 15rem), 50vw);
            height: calc(60vw / 16 * 9);
        }
    }
    </style>

    @if ($stream)
    <div id="player-and-chat">

        <div class="flex flex-col justify-center h-full lg:flex-row">

            <div class="flex flex-col mb-4 lg:mb-0 lg:mr-8 sm:rounded-lg" id="player-wrapper">
                <video id="my-player" class="w-full vjs-big-play-centered video-js" autoplay controls preload="auto" poster="{{url('/images/hogwarts_poster.jpg')}}" data-setup='{"fluid": true}'>
                    <source src="http://localhost:1936/live-stream/{{$stream->id}}/index.m3u8" type="application/x-mpegURL">
                    </source>
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">
                            supports HTML5 video
                        </a>
                    </p>
                </video>
                <div class="px-4 py-4 mt-4 bg-white rounded-lg shadow-xl ">
                    <div class="flex flex-col pb-2 mb-2 border-b border-gray-100 lg:items-start lg:justify-between lg:flex-row">
                        <div>
                            <h2 class="text-xl font-medium" id="stream-title">{{$stream->title ? $stream->title : "Stream of: " . $stream->owner->username}}</h2>
                            <h2 class="font-medium text-md" id="stream-description">{{$stream->description}}</h2>
                        </div>
                        <div class="pt-3 pb-1 mt-3 border-t border-gray-100 lg:mt-0 lg:py-0 lg:border-t-0">
                            <p class="flex items-center p-2 text-indigo-900 border rounded-md shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span id="stream-viewers-count" class="text-lg font-bold">0</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center py-2 mr-4 overflow-hidden lg:py-0">
                        <img src="{{ $stream->owner->profile_photo_url}}" class="w-12 h-12 mr-2 rounded-full shadow-sm">
                        <p class="text-lg font-medium">{{ '@'.$stream->owner->username }}</p>
                    </div>
                </div>
            </div>


            <div class="w-full lg:max-w-sm">
                <div class="flex flex-col h-full p-4 overflow-hidden bg-white shadow-xl lg:p-8 sm:rounded-lg " id="chat">
                    <h4 class="mb-4 text-2xl">Chat</h4>
                    <div id="chat-messages" class="flex-1 px-4 mb-4 overflow-y-auto border shadow rounded-md">
                    </div>
                    <script>
                        const elMessages = document.querySelector('#chat-messages')
                        const socket = io(window.SOCKET_ENDPOINT, {
                            transports: ['websocket', 'polling', 'flashsocket'],
                            query: {
                                streamId: @js($stream->id)
                            }
                        });
                        socket.on('message', function(payload) {
                            const {
                                data,
                                event
                            } = payload
                            if (event === 'chat.newMessage') {
                                elMessages.innerHTML += `<div class="py-2 border-b border-gray-200 last:border-b-0">${data.username}: ${data.message}</div>`
                                elMessages.scrollTop = elMessages.scrollHeight;
                            }

                            if(event === 'stream.updateMeta') {
                                const {title, description, tags} = data;
                                document.querySelector('#stream-title').innerText = title;
                                document.querySelector('#stream-description').innerText = description;
                            }

                            if(event === 'stream.updateViewersCount') {
                                const {count} = data;
                                document.querySelector('#stream-viewers-count').innerText = count;
                            }
                        })
    
                        const video = document.querySelector('#my-player')
                        const videoParent = document.querySelector('#player-wrapper')
                        const chat = document.querySelector('#chat')
                        
                        function setChatHeight() {
                                const width = video.clientWidth;
                                const height = (width * 9 / 16);
                                video.style.height = height + "px";
                                if(document.body.clientWidth > 1024) {
                                    const wrapperHeight =  videoParent.clientHeight;
                                    chat.style.minHeight =  wrapperHeight + 'px'
                                    chat.style.height = wrapperHeight + 'px'
                                } else {
                                    chat.style.height = 'auto'
                                    chat.style.minHeight = '560px'
                                }
                        }
                        setChatHeight();
                        window.addEventListener('resize', setChatHeight);
                    </script>

                    @livewire('stream-chat.message-send-form', ['streamId' => $stream->id])
                </div>
            </div>

        </div>

    </div>

    @if($isOwner)
        <div class="mx-auto mt-8 text-center max-w-7xl" x-data="{show: false}">
            <x-jet-secondary-button  @click="show = !show">
                <span x-show="show">
                    Hide Stream Settings
                </span>
                <span x-show="!show">
                    Show Stream Settings
                </span>
            </x-jet-secondary-button>

            <div class="mt-4 text-left" x-show="show">
                @livewire('stream.edit-form', ['stream' => $stream])
            </div>
        </div>
    @endif
    @else
        <div class="px-12 py-12 mx-auto bg-white rounded-lg shadow-lg max-w-7xl">
            <h2 class="text-xl text-center text-gray-700">The stream not started yet. You'll see it here when it starts.</h2>
        </div>
    @endif
</div>
