<?php
namespace App\Livewire\Admin\Users;

use App\Livewire\Component;
use App\Models\User;

class Show extends Component
{
    public $user;

    
    public \App\Livewire\Admin\Forms\UserForm $form;
    
    public function mount(User $user = null): void
    {
        auth()->user()->staffs()->findOrfail($user->id);
    }


    public function render()
    {
  
        return view('livewire.admin.users.show');
    }
}
