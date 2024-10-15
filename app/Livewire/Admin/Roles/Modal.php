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
        $this->success(__("Role created successfully."));
    }

    public function update(): void
    {
        $this->form->update();
        $this->success(__("Role updated successfully."));
    }

    private function success(string $message){
        $this->closeModal();
        $this->dispatch('refresh-list');
        \Toaster::success($message);
    }

    public function render(): View
    {
        return view('livewire.admin.roles.modal');
    }
}