<?php
namespace App\Livewire\Client\Products;

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

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($product = null): void
    {
        $this->product_types = (auth()->user()->client->product_types()->select(['id', 'name'])->get()->toArray());
        /**
         * Set product if product id is passed in route
         */
        if ($product) {
            $this->form->setProduct($this->product = auth()->user()->client->products()->findOrfail($product));
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
    }

    #[On('set-collections')]
    public function setCollections(array $collections): void
    {
        $this->form->collections = $collections;
    }

    #[On('set-product-type')]
    public function setProductType(string | null $product_type): void
    {
        $this->form->product_type = $product_type;
    }

    #[On('destroy-product-type')]
    public function destroyProductType(int $id): void
    {
        auth()->user()->client->product_types()->findOrfail($id)->delete();
        $this->product_types = (auth()->user()->client->product_types()->select(['id', 'name'])->get()->toArray());
        $this->dispatch('productTypeDeleted', [
            'product_types' => $this->product_types
        ]);
        $this->toasterSuccess(__("Product type deleted successfully."));
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
