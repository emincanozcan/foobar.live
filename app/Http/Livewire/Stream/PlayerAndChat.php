<?php

namespace App\Http\Livewire\Stream;

use App\Models\Stream;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PlayerAndChat extends Component
{
    public string $username;

    public Stream|null $stream;
    public string $streamUrl;
    public bool $exists;
    public bool $isOwner;

    public function mount()
    {
        $this->username = request('username');
        $this->fillStreamData();
    }

    public function fillStreamData()
    {
        $this->stream = User::where(['username' => $this->username])
            ->first()
            ->currentLiveStream();
        $this->exists = false;
        if ($this->stream) {
            $this->streamUrl = "http://localhost:1936/live-stream/{$this->stream->id}/index.m3u8";
            $this->localAccess = "http://rtmp-server:1936/live-stream/{$this->stream->id}/index.m3u8";
            $this->exists = Http::get($this->localAccess)->status() === 200;
        }
        $this->isOwner = auth()->check() && auth()->user()->username === $this->username;
    }

    public function render()
    {
        return view('livewire.stream.player-and-chat');
    }
}
