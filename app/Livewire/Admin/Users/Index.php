<?php
namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    public $users ;

    public function mount()
    {
        $this->users  = User::all();
    }

    // public function delete($id)
    // {
    //     User::find($id)->delete();
    //     $this->users  = User::all(); // Refresh posts list after deletion
    // }

    public function render()
    {
        return view('livewire.admin.users.index');
    }

    #[On('destroy')]
    public function destroy(string $id){
        User::findOrfail($id)->delete();
        $this->dispatch('refresh-list');
        \Toaster::success(__("User deleted successfully."));
        $this->dispatch('navigate_to', route('admin.users.index'));
    }
}
