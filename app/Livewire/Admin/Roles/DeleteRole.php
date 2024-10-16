<?php

namespace App\Livewire\Admin\Roles;

use App\Models\{Role, Permission};
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class DeleteRole extends ModalComponent
{
    public string|null $roleId;

    public function render(): View
    {
        return view('livewire.admin.roles.delete-role');
    }

    public function destroy(): void
    {
        $this->closeModal();
        Role::findOrfail($this->roleId)->delete();
        $this->dispatch('refresh-list');
        \Toaster::success(__("Role deleted successfully."));
    }
}