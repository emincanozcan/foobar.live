<div @unless($stream) wire:poll="fillStreamData" @endunless>
@if ($stream)
    <div>
        <div class="chat">
                @livewire('stream-chat.message-send-form', ['streamId' => $stream->id])
                <div id="chat-messages"></div>

                <script>
                    const elMessages = document.querySelector('#chat-messages')
                    const socket = io("http://localhost:4000", {
                        transports: ['websocket', 'polling', 'flashsocket'],
                        query: {
                            streamId: @js($stream->id)
                        }
                    });
                    socket.on('message', function (payload) {
                        const {data, event} = payload
                        if(event === 'chat.newMessage') {
                            elMessages.innerHTML += `<p>${data.username}: ${data.message}</p>`
                        }
                    })
                </script>
        </div>
        <div class="watch">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Watch Stream') }}
                </h2>
                <div>
                    <video id="my-player" style="width: 480px; height:auto;" class="video-js" controls preload="auto" poster="//vjs.zencdn.net/v/oceans.png" data-setup='{}'>
                        <source src="http://localhost:1936/live-stream/{{$stream->id}}/index.m3u8" type="application/x-mpegURL"></source>
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="https://videojs.com/html5-video-support/" target="_blank">
                                supports HTML5 video
                            </a>
                        </p>
                    </video>
                </div>
        </div>
    </div>
@else
    <h1>The stream not started yet. You'll see it here when it starts.</h1>
@endif

</div>
