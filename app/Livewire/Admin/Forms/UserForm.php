<?php

namespace App\Livewire\Admin\Forms;

use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use \App\Livewire\Form;

class UserForm extends Form
{
    use \App\Helper\Upload;
    use WithFileUploads;

    public ?User $user = null;
    public string|null $firstname = null;
    public string|null $lastname = null;
    public string|null $status;
    public string|null $phone = null;
    public string|null $email = null;
    public string|null $password = null;
    public string|null $role = null;
    public string|null $confirm_password = null;
    public string|null $phone_number = null;
    public ?UploadedFile $picture = null;
    public string|null $picture_url = null;
    public int $picture_removed = 0;

    public function setUser(?User $user = null): void
    {

        $this->user = $user;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->phone_number = $user->phone;
        $this->email = $user->email;
        $this->role = $user->role_id;
        $this->status = $user->status;
        $this->picture_url = $user->picture_url;
    }

    public function save()
    {

        $this->prepareValidation();
        $this->validate();

        try {
            /**
             * Create user if action is to create
             */
            if (!$this->user) {
                $this->user = User::create(
                    $this->only(['firstname', 'lastname', 'phone', 'email', 'password', 'status']) + [
                        'parent_id' => auth()->user()->employer_id, // Set current user employer as parent id
                    ]
                );
                /**
                 * Trigger Registered event
                 */
                try{
                    event(new \Illuminate\Auth\Events\Registered($this->user));
                }
                catch(\Exception $e){}
            } else {
                $this->user->update(
                    $this->only(['firstname', 'lastname', 'phone', 'email', 'password', 'status'])
                );
            }
            /**
             * Sync user role.
             */
            $this->user->roles()->sync($this->role);
            $this->user->updatePicture($this->picture, (int) $this->picture_removed);
            
            return ([
                'status' => 'success',
                'message' => $this->user->wasRecentlyCreated ? 'User created successfully.' : 'User updated successfully.',
                'redirect' => roleRoute('{role}.users.index'),
            ]);

        } catch (Exception $e) {
            return $this->error($e);
        }
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
            'confirm_password' => [$this->user ? 'nullable' : 'required'],
            'role' => ['required', 'exists:roles,id'],
            'status' => ['nullable'],
            'picture' => ["bail", "nullable", "image", "mimes:webp,jpg,png,jpeg", "max:2048"],
        ];
    }

    public function prepareValidation(): void
    {

        $this->phone = str_replace('-', '', filter_var($this->phone_number, FILTER_SANITIZE_NUMBER_INT));
        $this->status = isset($this->status) && $this->status ? '1' : '0';
    }
}
