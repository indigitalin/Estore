<?php
namespace App\Livewire\Client\Websites\Settings\Pages;

use App\Livewire\Form;
use App\Models\{Page, Website};
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class PageForm extends Form
{
    public ?Page $page = null;
    public ?Website $website = null;
    public string|null $title = null;
    public string|null $status;
    public string|null $content = null;
    public int|null $banner_id = null;

    public function setWebsite(?Website $website = null): void
    {
        $this->website = $website;
    }

    public function setPage(?Page $page = null): void
    {
        $this->page = $page;
        $this->title = $page->title ;
        $this->status = $page->status;
        $this->content = $page->content;
        $this->banner_id = $page->banner_id;
    }

    public function save()
    {
        $this->prepareValidation();
        $this->validate();
        try {
            if ($this->page) {
                // Update existing page
                $this->page->update($this->only([
                    'title', 'slug', 'status', 'content', 'banner_id'
                ]));
            } else {
                // Create new page
                $this->page = $this->website->pages()->create($this->only([
                    'title', 'slug', 'status', 'content', 'banner_id'
                ])+[
                    'client_id' => $this->website->client_id,
                ]);
            }
            return ([
                'status' => 'success',
                'message' => $this->page->wasRecentlyCreated ? 'Page created successfully.' : 'Page updated successfully.',
                'redirect' => route('client.websites.settings.pages.index', $this->website),
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
        $this->slug = \Illuminate\Support\Str::slug($this->title);
        $this->status = isset($this->status) && $this->status ? '1' : '0';
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:128', function ($attribute, $value, $fail) {
                $exists = $this->website->pages()->whereTitle($value)
                    ->whereNot('id', $this->page->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The page already exists, please create different one.');
                }
            }],
            'banner_id' => ['sometimes', 'nullable', 'exists:banners,id'],
            'status' => ['nullable'],
            'content' => ['required', 'string']
        ];
    }
}
