<?php
namespace App\Livewire\Client\Products;

use App\Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        /**
         * Load products created by current user or their employer
         */
        return view('livewire.client.products.index')->withProducts(
            auth()->user()->client->products()->paginate(20)
        );
    }

    #[On('status')]
    public function status(string $id)
    {
        $product = auth()->user()->client->products()->findOrfail($id);
        $product->update([
            'status' => $product->status == '0' ? '1' : '0',
        ]);
        $this->toasterSuccess(__("Product status updated successfully."));
    }

    #[On('destroy')]
    public function destroy(string $id){
        auth()->user()->client->products()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Product deleted successfully."));
    }
}
