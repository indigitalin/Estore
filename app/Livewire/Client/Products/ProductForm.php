<?php
namespace App\Livewire\Client\Products;

use App\Livewire\Form;
use App\Models\Product;
use Livewire\Attributes\On;
use Illuminate\Http\UploadedFile;
use Livewire\WithFileUploads;

class ProductForm extends Form
{
    public ?Product $product = null;
    public string|null $name = null;
    public string|null $handle;
    public string|null $status;
    public string|null $description = null;

    public function setProduct(?Product $product = null): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->handle = $product->handle;
        $this->status = $product->status;
        $this->description = $product->description;
    }

    public function save()
    {
        $this->prepareValidation();
        $this->validate();
        try {
            if ($this->product) {
                // Create new product
                $this->product->update($this->only(['name', 'handle', 'status', 'description']));
            } else {
                // Update existing product
                $this->product = auth()->user()->client->products()->create(
                    $this->only(['name', 'handle', 'status', 'description'])
                );
            }
            return ([
                'status' => 'success',
                'message' => $this->product->wasRecentlyCreated ? 'Product created successfully.' : 'Product updated successfully.',
                'redirect' => route('client.products.index'),
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
                $exists = auth()->user()->client->products()->whereName($value)
                    ->whereNot('id', $this->product->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The product already exists, please create different one.');
                }
            }],
            'description' => ['string', 'sometimes', 'nullable'],
            'status' => ['nullable'],
        ];
    }
}
