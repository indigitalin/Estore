<?php

namespace App\Livewire\Admin\Users;

use App\Models\User as ModelsUser;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;

use LivewireUI\Modal\ModalComponent;

class UserModal extends ModalComponent
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

    #[On('refresh-list')]
    public function refresh() {}

    public function render(): View
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
