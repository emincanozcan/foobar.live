@extends('layouts.base')
@section('content')
@livewire('stream-chat.message-send-form', ['streamId' => $stream->id])
<div>
    <div id="chat-messages"></div>
    <script src="https://cdn.socket.io/4.4.0/socket.io.min.js" integrity="sha384-1fOn6VtTq3PWwfsOrk45LnYcGosJwzMHv+Xh/Jx5303FVOXzEnw0EpLv30mtjmlj" crossorigin="anonymous"></script>
    <script>
        const elMessages = document.querySelector('#chat-messages')
        const socket = io("http://localhost:4000", {
            transports: ['websocket', 'polling', 'flashsocket'],
            query: {
                streamId: {{$stream->id}}
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

<h2 class="text-xl font-semibold leading-tight text-gray-800">
    {{ __('Watch Stream') }}
</h2>
<div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.10.2/video-js.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.10.2/video.min.js"></script>

    <video id="my-player" style="width: 480px; height:auto;" class="video-js" controls preload="auto" poster="//vjs.zencdn.net/v/oceans.png" data-setup='{}'>
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
@endsection
