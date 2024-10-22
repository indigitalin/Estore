<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use App\Models\{Role as RoleModel, Permission as PermissionModel};

class Role extends ModalComponent
{
    #[On('refresh-list')]
    public function refresh() {}

    public function render(): View
    {
        return view('livewire.admin.roles.index')->withRoles(
            RoleModel::whereNotNull('user_id')->get()
        );
    }

    #[On('destroy')]
    public function destroy(string $id){
        RoleModel::findOrfail($id)->delete();
        $this->dispatch('refresh-list');
        \Toaster::success(__("Role deleted successfully."));
    }
}
