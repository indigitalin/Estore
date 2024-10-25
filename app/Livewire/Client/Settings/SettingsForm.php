<?php

namespace App\Livewire\Client\Settings;

use \App\Livewire\Form;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class SettingsForm extends Form
{
    public ?Client $client = null;

    use \App\Helper\Upload;
    use WithFileUploads;

    /**
     * Client
     */
    public string|null $business_name = null;
    public string|null $industry_id = null;
    public string|null $description = null;
    public string|null $pan = null;
    public string|null $gst = null;
    public string|null $whatsapp_number = null;
    public string|null $whatsapp = null;
    public string|null $website = null;

    public string|null $address = null;
    public string|null $city = null;
    public string|null $postcode = null;
    public string|null $country_id = null;
    public string|null $state_id = null;

    public ?UploadedFile $logo = null;
    public string|null $logo_url = null;

    public int $picture_removed = 0;
    public int $logo_removed = 0;
    public function setClient(?Client $client = null): void
    {
        $this->client = $client;
        if ($client) {
            /**
             * Client
             */
            $this->business_name = $client->business_name;
            $this->industry_id = $client->industry_id;
            $this->description = $client->description;
            $this->pan = $client->pan;
            $this->gst = $client->gst;
            $this->whatsapp_number = $client->whatsapp;
            $this->whatsapp = $client->whatsapp;
            $this->website = $client->website;
            $this->logo_url = $client->logo_url;

            $this->address = $client->address;
            $this->city = $client->city;
            $this->postcode = $client->postcode;
            $this->country_id = $client->country_id;
            $this->state_id = $client->state_id;
        }
    }

    public function save()
    {
        $this->prepareValidation();
        $this->validate();
        try {
            $this->client->update($this->only(['business_name', 'industry_id', 'description', 'address', 'city', 'pan', 'gst', 'whatsapp', 'website', 'address', 'city', 'postcode', 'state_id', 'country_id']));

            $this->client->updateLogo($this->logo, (int) $this->logo_removed);

            return ([
                'status' => 'success',
                'message' => 'Company settings updated successfully.',
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
        $this->whatsapp = str_replace('-', '', filter_var($this->whatsapp_number, FILTER_SANITIZE_NUMBER_INT));
    }

    public function rules(): array
    {

        return [
            'business_name' => ['required', 'max:128'],
            'industry_id' => ['required', 'exists:industries,id'],
            'description' => ['required'],
            'address' => ['sometimes', 'nullable'],
            'gst' => ['sometimes', 'nullable', 'max:15'],
            'pan' => ['sometimes', 'nullable', 'max:10'],
            'whatsapp' => ['nullable', 'sometimes', 'numeric', 'digits:10'],
            'website' => ['nullable', 'sometimes', 'string', 'max:128'],

            'address' => ['sometimes', 'nullable', 'max:100'],
            'city' => ['sometimes', 'nullable', 'max:50'],
            'postcode' => ['sometimes', 'nullable', 'max:8'],

            'logo' => ["bail", "nullable", "image", "mimes:webp,jpg,png,jpeg", "max:2048"],
            'state_id' => ['nullable', 'sometimes', 'exists:states,id'],
            'country_id' => ['nullable', 'sometimes', 'exists:countries,id'],
        ];
    }
}
