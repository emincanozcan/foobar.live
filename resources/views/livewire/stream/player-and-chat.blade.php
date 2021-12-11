<div @unless($stream) wire:poll="fillStreamData" @endunless style="min-height: 100%;">
    @if ($stream)

    @if($isOwner)
        <div class="px-8 mx-auto mb-12 max-w-7xl">
            @livewire('stream.edit-form', ['stream' => $stream])
        </div>
    @endif
    <div style="height: 70vh;">
        <div class="flex justify-center h-full">
            <div class="flex flex-col h-full p-8 mr-8 overflow-hidden bg-white shadow-xl sm:rounded-lg " id="player-wrapper">
                <video id="my-player" class="video-js vjs-fill" style="height:100%; width:100%; aspect-ratio: 16/9;" controls preload="auto" poster="//vjs.zencdn.net/v/oceans.png" data-setup='{}'>
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
            </div>
            <div class="flex-shrink-0">
                <div class="flex flex-col h-full p-8 overflow-hidden bg-white shadow-xl sm:rounded-lg " id="chat">
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
                                elMessages.lastChild.scrollIntoView(false)
                            }

                            if(event === 'stream.updateMeta') {
                                const {title, description} = data;
                                document.querySelector('#stream-title').innerText = title;
                            }
                        })
    
                        const video = document.querySelector('#player-wrapper')
                        const chat = document.querySelector('#chat')
                        
                        function setChatHeight() {
                            const height = video.clientHeight;
                            chat.style.height = height + 'px'
                        }
                        setChatHeight();
                        window.addEventListener('resize', setChatHeight);
                    </script>

                    @livewire('stream-chat.message-send-form', ['streamId' => $stream->id])
                </div>
            </div>

        </div>

    </div>

    @else
        <div class="px-12 py-12 mx-auto bg-white rounded-lg shadow-lg max-w-7xl">
            <h2 class="text-xl text-center text-gray-700">The stream not started yet. You'll see it here when it starts.</h2>
        </div>
    @endif
</div>
