<?php

namespace App\Livewire\Admin\Forms;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Livewire\WithFileUploads;

class ClientForm extends Form
{
    public ?Client $client = null;

    use \App\Helper\Upload;
    use WithFileUploads;

    public string|null $firstname = null;
    public string|null $lastname = null;
    public string|null $status;
    public string|null $phone = null;
    public string|null $email = null;
    public string|null $password = null;
    public string|null $role = null;
    public string|null $confirm_password = null;
    public string|null $phone_number = null;
    public string|null $actual_picture = null;
    public ?UploadedFile $picture = null;
    public string|null $picture_url = null;

    public string|null $business_name = null;
    public string|null $industry = null;
    public string|null $description = null;
    public string|null $address = null;
    public string|null $city = null;
    public string|null $pan = null;
    public string|null $gst = null;
    public string|null $whatsapp_number = null;
    public string|null $whatsapp = null;
    public string|null $website = null;

    public function setClient(?Client $client = null): void
    {
        $this->client = $client;
    }

    public function save()
    {
        
        try {
            $this->prepareValidation();
        $this->validate();
            if ($this->client) {
                $this->client->user->update(
                    $this->only(['firstname', 'lastname', 'phone', 'email', 'password', 'status'])
                );
                $this->client->update(
                    $this->only(['business_name', 'industry', 'description', 'address', 'city', 'status', 'pan', 'gst', 'whatsapp'])
                );
            } else {
                $user = User::create(
                    $this->only(['firstname', 'lastname', 'phone', 'email', 'password', 'status'])
                );
                $this->client = $user->client()->create(
                    $this->only(['business_name', 'industry', 'description', 'address', 'city', 'status', 'pan', 'gst', 'whatsapp'])
                );
            }

            return ([
                'status' => 'success',
                'message' => 1 ? 'Client created successfully.' : 'Client updated successfully.',
                'redirect' => route('admin.clients.index'),
            ]);

        } catch (\Exception $e) {
            return ([
                'status' => 'error',
                'message' => "Something went wrong. {$e->getMessage()}",
            ]);
        }
    }

    public function prepareValidation(): void
    {

        $this->phone = str_replace('-', '', filter_var($this->phone_number, FILTER_SANITIZE_NUMBER_INT));
        $this->whatsapp = str_replace('-', '', filter_var($this->whatsapp_number, FILTER_SANITIZE_NUMBER_INT));
        $this->status = isset($this->status) ? '1' : '0';
    }

    public function rules(): array
    {

        return [
            'business_name' => ['required', 'max:128'],
            'industry' => ['required', 'max:128'],
            'description' => ['required'],
            'address' => ['sometimes', 'nullable'],
            'gst' => ['sometimes', 'nullable', 'max:15'],
            'pan' => ['sometimes', 'nullable', 'max:10'],
            'whatsapp' => ['nullable', 'sometimes','numeric','digits:10'],
            'website' => ['nullable', 'sometimes','string','max:128'],

            'firstname' => ['required', 'max:64'],
            'lastname' => ['required', 'max:64'],
            'phone' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique(User::class)->ignore($this->client ? $this->client->user_id : null),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->client ? $this->client->user_id : null),
            ],
            'password' => [
                $this->client ? 'nullable' : 'required',
                'same:confirm_password',
                new \App\Rules\StrongPassword,
            ],
            'confirm_password' => [$this->client ? 'nullable' : 'required'],
            'status' => ['nullable'],
            'picture' => ["bail", "nullable", "image", "mimes:webp,jpg,png,jpeg", "max:2048"],
        ];
    }
}
