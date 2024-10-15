<?php

namespace App\Livewire\Admin\Users;
use App\Models\User;
use Illuminate\Contracts\View\View;

use LivewireUI\Modal\ModalComponent;

class UserModalComponent extends ModalComponent
{
    public ?User $user = null;
    public \App\Livewire\Admin\Forms\UsersForm $form;

    public function mount(User $user = null): void
    {
        if ($user->exists) {
            $this->form->setUser($user);
        }
    }

    public function save(): void
    {
        $this->form->save();

        $this->closeModal();

        $this->dispatch('refresh-list');
    }

    public function render(): View
    {
        
        return view('livewire.admin.users.user-modal');
    }
}