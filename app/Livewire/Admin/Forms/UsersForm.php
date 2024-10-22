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
    public string|null $firstname = null;
    public string|null $lastname = null;
    public string|null $status;
    public string|null $phone = null;
    public string|null $email = null;
    public string|null $password = null;
    public string|null $type = 'customer';
    public string|null $confirm_password  = null;
    public string|null $phone_number  = null;
    public string|null $actual_picture  = null;
    public ?UploadedFile $picture = null;
    
    public string|null $picture_url = null ;

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
        $this->picture_url = $user->picture_url;
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

            $this->user->update([
                'parent_id' => auth()->user()->employer_id
            ]);

            if($this->picture != null){
                $this->user->update(['picture' => $picturePath ?? $this->user->picture]);
            }

            $msg['status'] = 'success';
            $msg['message'] = 'User succesfully created';

        } catch (Exception $e) {
            $msg['status'] = 'error';
            $msg['message'] = 'There was a problem saving the user: ' . $e->getMessage();
        }
        
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
                Rule::unique(User::class)->ignore($this->user ? $this->user->id : null),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user ? $this->user->id : null),
            ],
            'password' => [
                $this->user ? 'nullable' : 'required', 
                'same:confirm_password',
                new \App\Rules\StrongPassword,
            ],
            'confirm_password' => [$this->user ? 'nullable' : 'required',],
            'type' => ['required'],
            'status' => ['nullable'],
            'picture' => ["bail","nullable","image","mimes:webp,jpg,png,jpeg","max:2048"],
        ];
    }

    public function prepareValidation(): void
    {
       
        $this->phone = str_replace('-', '', filter_var($this->phone_number, FILTER_SANITIZE_NUMBER_INT));
        $this->status = isset($this->status) ? '1' : '0';
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
            'picture' => 'picture',
            'type' => 'type',
        ];
    }
}
