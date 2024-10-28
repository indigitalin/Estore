<?php
namespace App\Livewire\Client\Websites;

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
         * Load websites created by current user or their employer
         */
        return view('livewire.client.websites.index')->withWebsites(
            auth()->user()->client->websites()->paginate(20)
        );
    }

    #[On('status')]
    public function status(string $id)
    {
        $category = auth()->user()->client->websites()->findOrfail($id);
        $category->update([
            'status' => $category->status == '0' ? '1' : '0',
        ]);
        $this->toasterSuccess(__("Website status updated successfully."));
    }

    #[On('destroy')]
    public function destroy(string $id){
        auth()->user()->client->websites()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Website deleted successfully."));
    }
}
