<?php
namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.roles.index')->withRoles(
            Role::adminRoles()->paginate(10)
        );
    }

    #[On('destroy')]
    public function destroy(string $id){
        RoleModel::findOrfail($id)->delete();
        $this->dispatch('refresh-list');
        \Toaster::success(__("Role deleted successfully."));
    }
}
