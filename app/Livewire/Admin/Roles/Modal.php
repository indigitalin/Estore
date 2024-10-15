<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class Modal extends ModalComponent
{
    public ?Role $role = null;
    public \App\Livewire\Admin\Forms\RoleForm $form;

    public function mount(Role $role = null): void
    {
        if ($role->exists) {
            $this->form->setRole($role);
        }
    }

    public function store(): void
    {
        $this->form->store();
        $this->closeModal();
        $this->dispatch('refresh-list');
        \Toaster::success(__("Role created successfully."));
    }

    public function render(): View
    {
        return view('livewire.admin.roles.modal');
    }
}