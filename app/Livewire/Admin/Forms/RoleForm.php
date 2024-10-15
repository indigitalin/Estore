<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Role;
use Livewire\Form;
use Illuminate\Validation\Rule;

class RoleForm extends Form
{
    public ?Role $role = null;

    public string|null $name;

    public function setRole(?Role $role = null): void
    {
        $this->name = $role->name;
    }

    public function store(): void
    {
        $this->validate();
        Role::create([
            'user_id' => auth()->user()->id,
            'name' => $this->name,
            'guard_name' => 'web',
        ]);
        $this->reset();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required'
            ],
        ];
    }
}
