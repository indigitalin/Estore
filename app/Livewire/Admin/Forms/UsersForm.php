<?php

namespace App\Livewire\Admin\Forms;

use App\Models\User;
use Livewire\Form;
use Illuminate\Validation\Rule;

class UsersForm extends Form
{
    public ?User $user = null;

    public string $firstname,$lastname;
    public bool $status;
    public string $phone,$email,$password;
    public string $picture,$type;

    public function setUser(?User $user = null): void
    {
        $this->user = $user;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->status = $user->status;
        $this->picture = $user->picture;
    }

    public function save(): void
    {
        $this->validate();

        if (empty($this->product)) {
            User::create($this->only(['firstname', 'lastname','phone', 'email','password', 'status','picture']));
        } else {
            $this->user->update($this->only(['firstname', 'lastname','phone', 'email','password', 'status','picture']));
        }

        $this->reset();
    }

    public function rules(): array
    {
        return [
            'picture' => [
                'nullable'
            ],
            'firstname' => [
                'required',
            ],
            'lastname' => [
                'required'
            ],
            'phone'        => [
                'required',
                Rule::unique('users', 'phone')->ignore($this->component->user),
            ],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->component->user),
            ],
            'password'        => [
                'required'
            ],
            'status' => [
                'required'
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'phone' => 'phone',
            'email' => 'email',
            'password' => 'password',
            'status' => 'status',
            'picture' => 'picture'
        ];
    }
}
