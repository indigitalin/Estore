<?php
namespace App\Livewire\Client\Websites;

use App\Livewire\Form;
use App\Models\Website;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class WebsiteForm extends Form
{
    public ?Website $website = null;
    public string|null $name = null;
    public string|null $status;
    public ?UploadedFile $logo = null;
    public string|null $logo_url = null;
    public int $logo_removed = 0;

    public string|null $phone = null;
    public string|null $phone_number = null;
    public string|null $email = null;
    public string|null $website_link = null;

    public function setWebsite(?Website $website = null): void
    {
        $this->website = $website;
        $this->name = $website->name;
        $this->status = $website->status;
        $this->logo_url = $website->logo_url;

        $this->phone_number = $website->phone;
        $this->email = $website->email;
        $this->website_link = $website->website;
    }

    public function save()
    {
        $this->prepareValidation();
        $this->validate();
        try {
            if ($this->website) {
                // Create new website
                $this->website->update($this->only(['name', 'status']));
            } else {
                // Update existing website
                $this->website = auth()->user()->client->websites()->create(
                    $this->only(['name', 'status']) + [
                        'api_key' => strtoupper(\Illuminate\Support\Str::random(64)),
                    ]
                );
            }
            $this->website->update(
                $this->only(['email', 'phone']) + [
                    'website' => $this->website_link,
                ]
            );
            $this->website->updateLogo($this->logo, (int) $this->logo_removed);
            return ([
                'status' => 'success',
                'message' => $this->website->wasRecentlyCreated ? 'Website created successfully.' : 'Website updated successfully.',
                'redirect' => route('client.websites.index'),
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
                $exists = auth()->user()->client->websites()->whereName($value)
                    ->whereNot('id', $this->website->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The website already exists, please create different one.');
                }
            }],
            'status' => ['nullable'],
            'logo' => ["bail", "nullable", "image", "mimes:webp,jpg,png,jpeg", "max:2048"],
            'website_link' => ['required', 'string', 'max:128'],
            'phone' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique(Website::class)->ignore($this->website ? $this->website->id : null),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(Website::class)->ignore($this->website ? $this->website->id : null),
            ],
        ];
    }
}
