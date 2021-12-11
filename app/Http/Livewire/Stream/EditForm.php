<?php

namespace App\Http\Livewire\Stream;

use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class EditForm extends Component
{
    public $title;
    public $description;

    public $stream;

    public array $rules = [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:2048',
    ];

    public function mount()
    {
        $this->title = $this->stream->title;
        $this->description = $this->stream->description;
    }

    public function update()
    {
        if ($this->stream->owner->id !== request()->user()->id) {
            return;
        }

        $this->stream->update([
            'title' => $this->title,
            'description' =>$this->description
        ]);

        $data = [
            'event'  => 'stream.updateMeta',
            'data' => [
                'streamId' => $this->stream->id,
                'title' => $this->title,
                'description' => $this->description
            ]
        ];

        Redis::publish('chat-channel', json_encode($data));
    }

    public function render()
    {
        return view('livewire.stream.edit-form');
    }
}
