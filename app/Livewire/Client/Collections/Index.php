<?php
namespace App\Livewire\Client\Collections;

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
         * Load collections created by current user or their employer
         */
        return view('livewire.client.collections.index')->withCollections(
            auth()->user()->client->collections()->paginate(20)
        );
    }

    #[On('status')]
    public function status(string $id)
    {
        $collection = auth()->user()->client->collections()->findOrfail($id);
        $collection->update([
            'status' => $collection->status == '0' ? '1' : '0',
        ]);
        $this->toasterSuccess(__("Collection status updated successfully."));
    }

    #[On('destroy')]
    public function destroy(string $id){
        auth()->user()->client->collections()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Collection deleted successfully."));
    }
}
