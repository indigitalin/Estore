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
        $this->users  = auth()->user()->staffs()->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.users.index');
    }

    #[On('destroy')]
    public function destroy(string $id){
        auth()->user()->staffs()->findOrfail($id)->delete();
        $this->dispatch('refresh-list');
        \Toaster::success(__("User deleted successfully."));
        $this->dispatch('navigate_to', route('admin.users.index'));
    }
}
