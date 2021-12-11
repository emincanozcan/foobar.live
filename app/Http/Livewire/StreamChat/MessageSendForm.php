<?php

namespace App\Http\Livewire\StreamChat;

use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class MessageSendForm extends Component
{
    public string $message = "";
    public int $streamId;

    public function mount($streamId)
    {
        $this->streamId = $streamId;
    }

    public function sendMessage()
    {
        $data = [
            'event'  => 'chat.newMessage',
            'data' => [
                'username' => auth()->user()->username,
                'message' => $this->message,
                'streamId' => $this->streamId
            ]
        ];

        Redis::publish('chat-channel', json_encode($data));

        $this->message = "";
    }

    public function render()
    {
        return view('livewire.stream-chat.message-send-form');
    }
}
