<?php
namespace App\Livewire\Admin\Roles;

use App\Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        /**
         * Load roles created by current user or their employer
         */
        return view('livewire.admin.roles.index')->withRoles(
            Role::adminRoles()->paginate(10)
        );
    }

    #[On('destroy')]
    public function destroy(string $id){
        Role::adminRoles()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Role deleted successfully."));
    }
}
