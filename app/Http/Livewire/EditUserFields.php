<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class EditUserFields extends Component
{
    public $role = 'user';

    public User $user;

    public function render()
    {
        return view('livewire.edit-user-fields');
    }
}