<?php

namespace App\Livewire\Admin\Forms;

use App\Models\User;
use Exception;
use Livewire\Form;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class UsersForm extends Form
{
    use \App\Helper\Upload;
    public ?User $user = null;
    use WithFileUploads;
    public string|null $firstname,$lastname;
    public bool|null $status;
    public string|null $phone,$email,$password;
    public string|null $picture,$type,$picture_url;
    public string|null $confirm_password;
    public string|null $phone_number,$actual_picture;
    

    public function setUser(?User $user = null): void
    {
        $this->user = $user;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->phone_number = $user->phone;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->status = $user->status;
        $this->picture = $user->picture;
        $this->actual_picture = $user->picture;
        $this->picture_url = $user->picture_url;
    }

    public function save(): void
    {
    
        $this->prepareValidation();
        $this->validate();
          
        try {

            if ($this->picture != null) {
                if (!empty($this->user)) {
                    $this->removeFile($this->actual_picture);
                }
                $picturePath = $this->uploadFile(file : $this->picture, path : 'avatars', maxHeight : 200, maxWidth : 200, ratio: '1:1');
                $this->picture = $picturePath;
            }
 
            if (empty($this->user)) {
                User::create($this->only(['firstname', 'lastname', 'phone', 'email', 'password', 'status', 'picture']));
            } else {
                
                $this->user->update($this->only(['firstname', 'lastname', 'phone', 'email', 'password', 'status']));

                if($this->picture != null){
                    $this->user->update($this->only(['picture']));
                }
            }
        } catch (Exception $e) {
            session()->flash('error', 'There was a problem saving the user: ' . $e->getMessage());
        }

        $this->reset();
    }

    public function rules(): array
    {
        return [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'phone' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('users', 'phone')->ignore($this->user ? $this->user->id : null),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user ? $this->user->id : null),
            ],
            'password' => [
                'required',
                'same:confirm_password',
                new \App\Rules\StrongPassword,
            ],
            'confirm_password' => ['required'],
            'type' => ['required'],
            'status' => ['nullable'],
            'picture' => "bail|nullable|image|mimes:webp,jpg,png,jpeg|max:2048",
        ];
    }

    public function prepareValidation(): void
    {
        $this->phone = str_replace('-', '', filter_var($this->phone_number, FILTER_SANITIZE_NUMBER_INT));
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
