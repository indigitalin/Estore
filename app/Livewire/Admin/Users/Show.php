<?php
namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;

class Show extends Component
{
    public $user;

    
    public \App\Livewire\Admin\Forms\UsersForm $form;
    
    public function mount(User $user = null): void
    {
        if ($user && $user->exists) {
            $this->form->setUser($user);
        }
    }


    public function render()
    {
  
        return view('livewire.admin.users.show');
    }
}
