<?php
namespace App\Livewire\Client\Stores;

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
         * Load stores created by current user or their employer
         */
        return view('livewire.client.stores.index')->withStores(
            auth()->user()->client->stores()->paginate(20)
        );
    }

    #[On('status')]
    public function status(string $id)
    {
        $category = auth()->user()->client->stores()->findOrfail($id);
        $category->update([
            'status' => $category->status == '0' ? '1' : '0',
        ]);
        $this->toasterSuccess(__("Store status updated successfully."));
    }

    #[On('destroy')]
    public function destroy(string $id){
        auth()->user()->client->stores()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Store deleted successfully."));
    }
}
