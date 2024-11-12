<?php
namespace App\Livewire\Client\Products;

use App\Livewire\Component;
use App\Models\{Role, Permission};
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

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($product = null): void
    {
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
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
