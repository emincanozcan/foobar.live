<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;

class EditUsernameForm extends Component
{
    public string $username;

    public array $rules = [
        'username' => 'required|max:255|unique:users',
    ];

    public function mount()
    {
        $this->username = request()->user()->username;
    }

    public function update()
    {
        $this->validate();
        request()->user()->update(['username' => $this->username]);
        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.profile.edit-username-form');
    }
}
