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
                <video id="my-player" class="w-full video-js" controls preload="auto" poster="//vjs.zencdn.net/v/oceans.png" data-setup='{"fluid": true}'>
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
                <div class="px-4 py-4 mt-4 bg-white rounded-lg shadow-xl">
                    <h2 class="text-lg font-medium" id="stream-description">{{$stream->description}}</h2>
                </div>
            </div>


            <div class="w-full lg:max-w-sm">
                <div class="flex flex-col h-full p-4 overflow-hidden bg-white shadow-xl lg:p-8 sm:rounded-lg " id="chat">
                    <h4 class="mb-4 text-2xl">Chat</h4>
                    <div id="chat-messages" class="flex-1 px-4 mb-4 overflow-y-auto border shadow rounded-md">
                    </div>
                    <script>
                        const elMessages = document.querySelector('#chat-messages')
                        const socket = io("http://localhost:4000", {
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
                        })
    
                        const video = document.querySelector('#my-player')
                        const videoParent = document.querySelector('#player-wrapper')
                        const chat = document.querySelector('#chat')
                        
                        function setChatHeight() {
                                const width = video.clientWidth;
                                const height =(width * 9 / 16);
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
        <div class="mx-auto mt-8 text-right max-w-7xl" x-data="{show: false}">
            <x-jet-secondary-button  @click="show = !show">Show Stream Settings</x-jet-secondary-button>

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
