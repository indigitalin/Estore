<?php

namespace App\Livewire\Admin\Forms;

use App\Models\User;
use Exception;
use Livewire\Form;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class UsersForm extends Form
{
    use \App\Helper\Upload;
    public ?User $user = null;
    use WithFileUploads;
    public string|null $firstname,$lastname;
    public bool|null $status;
    public string|null $phone,$email,$password;
    public string|null $type;
    public string|null $confirm_password;
    public string|null $phone_number,$actual_picture;
    public ?UploadedFile $picture = null;
    
    public string|null $picture_url ;

    public function setUser(?User $user = null): void
    {
        $this->user = $user;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->phone_number = $user->phone;
        $this->email = $user->email;
        $this->type = $user->type;
        $this->password = '';
        $this->status = $user->status;
        // $this->picture = $user->picture;
        $this->actual_picture = $user->picture;
        $this->picture_url = $user->picture_url ? $user->picture_url  : 'https://ui-avatars.com/api//?background=5c60f5&color=fff&name=';
    }

    public function defaultValues(): void{
     
        $this->picture_url = 'https://ui-avatars.com/api//?background=5c60f5&color=fff&name=';
    }

    public function save()
    {
    
        $this->prepareValidation();
        $this->validate();
          
        try {

            if ($this->picture != null) {
                if (!empty($this->user)) {
                    $this->removeFile($this->actual_picture);
                }
                $picturePath = $this->uploadFile(file : $this->picture, path : 'avatars', maxHeight : 200, maxWidth : 200, ratio: '1:1');
              
            }
 
            if (empty($this->user)) {
                $this->user = User::create($this->only(['firstname', 'lastname', 'phone', 'email', 'password', 'status', 'picture']));
            } else {
                $this->user->update($this->only(['firstname', 'lastname', 'phone', 'email', 'password', 'status'])); 
            }
            if($this->picture != null){
                $this->user->update(['picture' => $picturePath ?? $this->user->picture]);
            }

            $msg['status'] = 'success';
            $msg['message'] = 'User succesfully created';

        } catch (Exception $e) {
            $msg['status'] = 'error';
            $msg['message'] = 'There was a problem saving the user: ' . $e->getMessage();
        }

        $this->reset();
        
        return $msg;
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
            'picture' => ["bail","nullable","image","mimes:webp,jpg,png,jpeg","max:2048"],
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
