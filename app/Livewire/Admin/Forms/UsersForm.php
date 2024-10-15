<?php

namespace App\Livewire\Admin\Forms;

use App\Models\User;
use Livewire\Form;
use Illuminate\Validation\Rule;

class UsersForm extends Form
{
    public ?User $user = null;

    public string $firstname,$lastname;
    public bool $status = 0;
    public string $phone,$email,$password;
    public string $picture,$type;

    public function setUser(?Product $product = null): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->description = $product->description;
    }

    public function save(): void
    {
        $this->validate();

        if (empty($this->product)) {
            Product::create($this->only(['name', 'description']));
        } else {
            $this->product->update($this->only(['name', 'description']));
        }

        $this->reset();
    }

    public function rules(): array
    {
        return [
            'name'        => [
                'required',
                Rule::unique('products', 'name')->ignore($this->component->product),
            ],
            'description' => [
                'required'
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => 'name',
            'description' => 'description',
        ];
    }
}
