<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;

class StreamKeyForm extends Component
{
    public $streamKey = '';

    public function mount()
    {
        $this->streamKey = request()->user()->stream_key;
    }

    public function render()
    {
        return view('livewire.profile.stream-key-form');
    }

    public function regenerate()
    {
        request()->user()->regenerateStreamKey();
        $this->streamKey = request()->user()->stream_key;
        $this->emit('regenerated');
    }
}
