<?php

namespace App\Http\Livewire\Home;

use App\Models\Stream;
use App\Models\Tag;
use Livewire\Component;

class StreamList extends Component
{
    public array $streams = [];

    public array $tags = [];

    public $filteredTags;

    public string $tagSearch = '';

    public function addTag($tagId)
    {
        array_push($this->tags, Tag::findOrFail($tagId));
    }

    public function removeTag($tagId)
    {
        $this->tags = array_filter($this->tags, fn ($tag) => $tagId !== $tag['id']);
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
            ->where('name', 'ILIKE', '%'.$this->tagSearch.'%')
            ->get();
    }

    public function render()
    {
        $this->setTags();
        $this->streams = Stream::query()
            ->when(count($this->tags) > 0, function ($query) {
                $selectedTagIds = collect($this->tags)->map(fn ($tag) => $tag['id']);

                return $query->whereHas('tags', function ($q) use ($selectedTagIds) {
                    return $q->whereIn('id', $selectedTagIds);
                });
            })
            ->with('owner')
            ->get()
            ->toArray();

        return view('livewire.home.stream-list');
    }
}
