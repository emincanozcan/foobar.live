<?php

namespace App\Http\Livewire\Stream;

use App\Models\Tag;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class EditForm extends Component
{
    public string|null $title = "";
    public string|null $description = "";

    public array $tags = [];
    public $availableTags;
    public $filteredTags;

    public $stream;
    public string $tagSearch = "";

    public array $rules = [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:2048',
        'tags' => 'nullable|array',
    ];

    public function addTag($tagId)
    {
        array_push($this->tags, Tag::findOrFail($tagId));
    }

    public function removeTag($tagId)
    {
        $this->tags = array_filter($this->tags, fn ($tag) => $tagId !== $tag['id']);
    }

    public function mount()
    {
        $this->title = $this->stream->title;
        $this->description = $this->stream->description;
        $this->tags = $this->stream->tags()->get()->toArray();
    }

    public function setTags()
    {
        // TODO: send all tags to frontend, and filter them via javascript.
        //
        // NOTE: As I remember, ILIKE is Postgresql only function, not a standart one. It might not work on MySQL or other databases.
        $this->filteredTags = Tag::select('id', 'name')
        ->whereNotIn(
            'id',
            collect($this->tags)->map(fn ($tag) => $tag['id'])
        )
            ->where('name', 'ILIKE', '%' . $this->tagSearch . '%')
            ->get();
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

        $this->stream->tags()->sync(
            collect($this->tags)->map(fn ($tag) => $tag['id'])->toArray()
        );

        $data = [
            'event'  => 'stream.updateMeta',
            'data' => [
                'streamId' => $this->stream->id,
                'title' => $this->title,
                'description' => $this->description,
                'tags' => $this->tags,
            ]
        ];

        Redis::publish('chat-channel', json_encode($data));
    }

    public function render()
    {
        $this->setTags();
        return view('livewire.stream.edit-form');
    }
}
