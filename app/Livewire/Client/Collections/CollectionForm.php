<?php
namespace App\Livewire\Client\Collections;

use App\Livewire\Form;
use App\Models\Collection;
use Livewire\Attributes\On;
use Illuminate\Http\UploadedFile;
use Livewire\WithFileUploads;

class CollectionForm extends Form
{
    public ?Collection $collection = null;
    public string|null $name = null;
    public string|null $handle;
    public string|null $status;
    public string|null $description = null;
    public int|null $parent_id = null;
    public ?UploadedFile $picture = null;
    public int $picture_removed = 0;

    public string|null $seo_title = null;
    public string|null $seo_description = null;
    public string|null $seo_keywords = null;

    public function setCollection(?Collection $collection = null): void
    {
        $this->collection = $collection;
        $this->name = $collection->name;
        $this->handle = $collection->handle;
        $this->status = $collection->status;
        $this->description = $collection->description;
        $this->parent_id = $collection->parent_id;

        $this->seo_title = $collection->seo_title;
        $this->seo_description = $collection->seo_description;
        $this->seo_keywords = $collection->seo_keywords;
    }

    public function save()
    {
        $this->prepareValidation();
        $this->validate();
        try {
            if ($this->collection) {
                // Create new collection
                $this->collection->update($this->only(['name', 'handle', 'status', 'description', 'parent_id']));
            } else {
                // Update existing collection
                $this->collection = auth()->user()->client->collections()->create(
                    $this->only(['name', 'handle', 'status', 'description', 'parent_id'])
                );
            }
            $this->collection->update($this->only([
                'seo_title',
                'seo_keywords',
                'seo_description',
            ]));
            $this->collection->updatePicture($this->picture, (int) $this->picture_removed);
            return ([
                'status' => 'success',
                'message' => $this->collection->wasRecentlyCreated ? 'Collection created successfully.' : 'Collection updated successfully.',
                'redirect' => route('client.collections.index'),
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
        $this->handle = \Illuminate\Support\Str::slug($this->name);
        $this->status = isset($this->status) && $this->status ? '1' : '0';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:128', function ($attribute, $value, $fail) {
                $exists = auth()->user()->client->collections()->whereName($value)
                    ->whereNot('id', $this->collection->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The collection already exists, please create different one.');
                }
            }],
            'description' => ['string', 'sometimes', 'nullable'],
            'status' => ['nullable'],
            'parent_id' => ['nullable', 'sometimes', 'exists:collections,id'],
            'picture' => ["bail", "nullable", "image", "mimes:webp,jpg,png,jpeg", "max:2048"],
            'seo_title' => ['sometimes', 'nullable', 'string'],
            'seo_keywords' => ['sometimes', 'nullable', 'string'],
            'seo_description' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
