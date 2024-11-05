<?php
namespace App\Livewire\Client\Categories;

use App\Livewire\Form;
use App\Models\Category;
use Livewire\Attributes\On;
use Illuminate\Http\UploadedFile;
use Livewire\WithFileUploads;

class CategoryForm extends Form
{
    public ?Category $category = null;
    public string|null $name = null;
    public string|null $handle;
    public string|null $status;
    public string|null $description = null;
    public int|null $parent_id = null;
    public ?UploadedFile $picture = null;
    public int $picture_removed = 0;

    public function setCategory(?Category $category = null): void
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->handle = $category->handle;
        $this->status = $category->status;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;
    }

    public function save()
    {
        $this->prepareValidation();
        $this->validate();
        try {
            if ($this->category) {
                // Create new category
                $this->category->update($this->only(['name', 'handle', 'status', 'description', 'parent_id']));
            } else {
                // Update existing category
                $this->category = auth()->user()->client->categories()->create(
                    $this->only(['name', 'handle', 'status', 'description', 'parent_id'])
                );
            }
            $this->category->updatePicture($this->picture, (int) $this->picture_removed);
            return ([
                'status' => 'success',
                'message' => $this->category->wasRecentlyCreated ? 'Category created successfully.' : 'Category updated successfully.',
                'redirect' => route('client.categories.index'),
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
        $this->status = isset($this->status) ? '1' : '0';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:128', function ($attribute, $value, $fail) {
                $exists = auth()->user()->client->categories()->whereName($value)
                    ->whereNot('id', $this->category->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The category already exists, please create different one.');
                }
            }],
            'description' => ['string', 'sometimes', 'nullable'],
            'status' => ['nullable'],
            'parent_id' => ['nullable', 'sometimes', 'exists:categories,id'],
            'picture' => ["bail", "nullable", "image", "mimes:webp,jpg,png,jpeg", "max:2048"],
        ];
    }
}
