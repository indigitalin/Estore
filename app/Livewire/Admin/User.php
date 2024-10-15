<?php

namespace App\Livewire\Admin;

use App\Models\User as ModelsUser;
use Livewire\Component;

class User extends Component
{
    public $count = 1;
 
    public function increment()
    {
        $this->count++;
    }
 
    public function decrement()
    {
        $this->count--;
    }

    public function render()
    {
        $users = ModelsUser::
        // where(function ($query) {
        //     $query->where('type', '=', 'admin')
        //           ->orWhere('type', '=', 'admin-staff');
        // })->
        get();

        return view('livewire.admin.users.index',)->with(compact('users'));
    }

    
}
