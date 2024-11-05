<?php
namespace App\Livewire\Client\Stores;

use App\Livewire\Form;
use App\Models\Store;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class StoreForm extends Form
{
    public ?Store $store = null;
    public string|null $name = null;
    public string|null $status;
    public ?UploadedFile $logo = null;
    public string|null $logo_url = null;
    public int $logo_removed = 0;

    public string|null $address = null;
    public string|null $city = null;
    public string|null $postcode = null;
    public string|null $country_id = null;
    public string|null $state_id = null;

    public string|null $latitude = null;
    public string|null $longitude = null;

    public string|null $phone = null;
    public string|null $phone_number = null;
    public string|null $email = null;
    public string|null $password = null;
    public string|null $confirm_password = null;

    public function setStore(?Store $store = null): void
    {
        $this->store = $store;
        $this->name = $store->name;
        $this->status = $store->status;
        $this->logo_url = $store->logo_url;

        $this->address = $store->address;
        $this->city = $store->city;
        $this->postcode = $store->postcode;
        $this->country_id = $store->country_id;
        $this->state_id = $store->state_id;

        $this->phone_number = $store->phone;
        $this->email = $store->email;

        $this->latitude = $store->latitude;
        $this->longitude = $store->longitude;

    }

    public function save()
    {
        // dd($this);
        $this->prepareValidation();
        $this->validate();
        try {
            if ($this->store) {
                // Create new store
                $this->store->update($this->only(['name', 'status']));
            } else {
                // Update existing store
                $this->store = auth()->user()->client->stores()->create(
                    $this->only(['name', 'status']) + [
                        'api_key' => strtoupper(\Illuminate\Support\Str::random(64)),
                    ]
                );
            }
            $this->store->update(
                $this->only(['latitude', 'longitude', 'email', 'phone', 'address', 'city', 'postcode', 'state_id', 'country_id', 'email', 'phone'])
            );
            $this->store->updateLogo($this->logo, (int) $this->logo_removed);

            /**
             * Change password only if requested
             */
            if ($this->password) {
                $this->store->update(
                    $this->only(['password'])
                );
            }

            return ([
                'status' => 'success',
                'message' => $this->store->wasRecentlyCreated ? 'Store created successfully.' : 'Store updated successfully.',
                'redirect' => route('client.stores.index'),
            ]);

        } catch (\Exception $e) {

            return $this->error($e);
        }
    }

    /**
     * Before validation, prepare the values and do necessary changes
     */
    public function prepareValidation(): void
    {
        $this->phone = str_replace('-', '', filter_var($this->phone_number, FILTER_SANITIZE_NUMBER_INT));
        $this->status = isset($this->status) ? '1' : '0';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:128', function ($attribute, $value, $fail) {
                $exists = auth()->user()->client->stores()->whereName($value)
                    ->whereNot('id', $this->store->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The store already exists, please create different one.');
                }
            }],
            'status' => ['nullable'],
            'logo' => ["bail", "nullable", "image", "mimes:webp,jpg,png,jpeg", "max:2048"],

            'phone' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique(Store::class)->ignore($this->store ? $this->store->id : null),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('stores', 'email')->ignore($this->store ? $this->store->id : null),
            ],
            'password' => [
                'nullable', 'sometimes',
                'same:confirm_password',
                new \App\Rules\StrongPassword,
            ],
            'confirm_password' => ['nullable', 'sometimes'],
            'latitude' => [
                'sometimes',
                'nullable',
                'numeric',
                'between:-90,90', // Valid latitude range
            ],
            'longitude' => [
                'sometimes',
                'nullable',
                'numeric',
                'between:-180,180', // Valid longitude range
            ],
        ];
    }
}
