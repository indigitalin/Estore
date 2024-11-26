<?php
namespace App\Livewire\Client\Products;

use App\Http\Resources\ProductOptionResource;
use App\Http\Resources\ProductVariationResource;
use App\Livewire\Component;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $product;
    public \App\Livewire\Client\Products\ProductForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    protected $listeners = ['refreshList' => '$refresh'];
    public $product_types = [];
    public $product_vendors = [];
    protected $product_options = [];
    protected $product_variations = [];
    protected $product_images = [];

    public $images = [];
    private $allowed_images = ['jpeg', 'jpg', 'png', 'webp'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($product = null): void
    {
        $this->product_types = (auth()->user()->client->product_types()->select(['id', 'name'])->get()->toArray());
        $this->product_vendors = (auth()->user()->client->product_vendors()->select(['id', 'name'])->get()->toArray());
        /**
         * Set product if product id is passed in route
         */
        if ($product) {
            $this->form->setProduct($this->product = auth()->user()->client->products()->findOrfail($product));
            $this->product_options = ProductOptionResource::collection($this->product->product_options);
            $this->product_variations = ProductVariationResource::collection($this->product->product_variations);
            $this->product_images = $this->product->product_images->toArray();
        }
    }

    public function render(): View
    {
        return view('livewire.client.products.form')->withCategories(
            \App\Http\Resources\CategoryResource::collection(
                auth()->user()->client->categories()->whereNull('parent_id')->get()
            )
        )->withStores(
            auth()->user()->client->stores
        )->withWebsites(
            auth()->user()->client->websites
        )->withCollections(
            \App\Http\Resources\CollectionResource::collection(
                auth()->user()->client->collections
            )
        );
    }

    #[On('set-category')]
    public function setCategory(string $category): void
    {
        $this->form->category_id = $category;
        $this->validateOnly('category_id');
    }

    #[On('set-collections')]
    public function setCollections(array $collections): void
    {
        $this->form->collections = $collections;
        $this->validateOnly('collections');
    }

    #[On('set-product-tags')]
    public function setProductTags(array $product_tags): void
    {
        $this->form->product_tags = $product_tags;
        $this->validateOnly('product_tags');
    }

    #[On('set-product-type')]
    public function setProductType(string | null $product_type): void
    {
        $this->form->product_type = $product_type;
        $this->validateOnly('product_type');
    }

    #[On('destroy-product-type')]
    public function destroyProductType(int $id): void
    {
        auth()->user()->client->product_types()->findOrfail($id)->delete();
        $this->product_types = (auth()->user()->client->product_types()->select(['id', 'name'])->get()->toArray());
        $this->dispatch('productTypeDeleted', [
            'product_types' => $this->product_types,
        ]);
        $this->toasterSuccess(__("Product type deleted successfully."));
    }

    #[On('set-product-vendor')]
    public function setProductVendor(string | null $product_vendor): void
    {
        $this->form->product_vendor = $product_vendor;
        $this->validateOnly('product_vendor');
    }

    #[On('destroy-product-vendor')]
    public function destroyProductVendor(int $id): void
    {
        auth()->user()->client->product_vendors()->findOrfail($id)->delete();
        $this->product_vendors = (auth()->user()->client->product_vendors()->select(['id', 'name'])->get()->toArray());
        $this->dispatch('productVendorDeleted', [
            'product_vendors' => $this->product_vendors,
        ]);
        $this->toasterSuccess(__("Product vendor deleted successfully."));
    }

    #[On('set-product-options')]
    public function setOptions(array $product_options): void
    {
        $this->form->product_options = $product_options;
        $this->validateOnly('product_options');
    }

    #[On('set-product-variations')]
    public function setVariations(array $product_variations): void
    {
        $this->form->product_variations = $product_variations;
        $this->validateOnly('product_variations');
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }

    #[On('destroy-image')]
    public function destroyImage($id): void
    {
        auth()->user()->client->product_images()->findOrfail($id)->remove();
        $this->dispatch('imageDeleted', [
            'image_id' => $id,
        ]);
        $this->toasterSuccess(__("Image deleted successfully."));
    }

    public function updatedImages()
    {
        foreach ($this->images as $image) {
            $fileName = $image->getClientOriginalName();
            if ($image->isValid() && in_array(strtolower($image->getClientOriginalExtension()), $this->allowed_images)) {
                // Check if the size is more than 2MB (2MB = 2097152 bytes)
                if ($image->getSize() > 2097152) {
                    // Handle the case when the image size is more than 2MB
                    // For example, you can throw an error or skip processing this image
                    $this->toasterError(__("{$fileName} is larger than 2mb."));
                } else {
                    $productImage = auth()->user()->client->product_images()->create([
                        'product_id' => $this->product->id ?? null,
                    ]);
                    $productImage->updateImage($image);

                    $this->dispatch('imageUploaded', [
                        'image' => $productImage,
                    ]);
                }
            } else {
                // Handle invalid image files (non-image files or unsupported file formats)
                $this->toasterError(__("{$fileName} is not an image."));
            }
        }
    }
}
