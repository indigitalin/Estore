<?php

namespace App\Livewire\Admin\Roles;

use App\Models\{Role, Permission};
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class Permissions extends ModalComponent
{
    public ?Role $role = null;
    
    public function render(): View
    {
        return view('livewire.admin.roles.permissions');
    }
}