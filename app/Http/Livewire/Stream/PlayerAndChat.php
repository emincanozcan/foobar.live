<?php

namespace App\Http\Livewire\Stream;

use App\Models\Stream;
use App\Models\User;
use Livewire\Component;

class PlayerAndChat extends Component
{
    public string $username;

    public Stream|null $stream;
    public bool $exists;
    public bool $isOwner;

    public function mount()
    {
        $this->username = request('username');
        $this->fillStreamData();
    }

    public function fillStreamData()
    {
        $this->stream = User::where(['username'=> $this->username])
             ->first()
             ->currentLiveStream();

        $this->exists = $this->stream ? true : false;
        $this->isOwner = auth()->check() && auth()->user()->username === $this->username;
    }

    public function render()
    {
        return view('livewire.stream.player-and-chat');
    }
}
