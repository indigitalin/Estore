<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Role;
use \App\Livewire\Form;
use Illuminate\Validation\Rule;

class RoleForm extends Form
{
    public ?Role $role = null;
    public string|null $name = null;
    public array|null $permissions;

    public function setRole(?Role $role = null): void
    {
        $this->role = $role;
        $this->name = $role->name;
        $this->permissions = $role->permissions->pluck('id')->toArray();
    }

    public function save()
    {
        try {

            $this->role = $this->role ? : Role::create([
                'user_id' => auth()->user()->id,
                'name' => $this->name,
                'guard_name' => 'web',
            ]);
            $this->role->update($this->only(['name']));
            $this->role->permissions()->sync($this->permissions);

            return ([
                'status' => 'success',
                'message' => $this->role->wasRecentlyCreated ? 'Role created successfully.' : 'Role updated successfully.',
                'redirect' => roleRoute('{role}.roles.index'),
            ]);

        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    public function rules(): array
    {
        return [
            'permissions' => 'sometimes|nullable|array',
            'permissions.*' => 'exists:permissions,id',
            'name' => ['required', function ($attribute, $value, $fail) {
                $exists = \App\Models\Role::whereName($value)
                    ->whereUserId(auth()->user()->id)
                    ->whereNot('id', $this->role->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The role already exists, please create different one.');
                }
            }],
        ];
    }
}
