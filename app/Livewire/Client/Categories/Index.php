<?php
namespace App\Livewire\Client\Categories;

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
         * Load categories created by current user or their employer
         */
        return view('livewire.client.categories.index')->withCategories(
            auth()->user()->client->categories()->paginate(20)
        );
    }

    #[On('status')]
    public function status(string $id)
    {
        $category = auth()->user()->client->categories()->findOrfail($id);
        $category->update([
            'status' => $category->status == '0' ? '1' : '0',
        ]);
        $this->toasterSuccess(__("Category status updated successfully."));
    }

    #[On('destroy')]
    public function destroy(string $id){
        auth()->user()->client->categories()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Category deleted successfully."));
    }
}
