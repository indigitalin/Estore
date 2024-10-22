<?php
namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.users.index')->withUsers(
            auth()->user()->staffs()->paginate(10)
        );
    }

    #[On('destroy')]
    public function destroy(string $id){
        auth()->user()->staffs()->findOrfail($id)->delete();
        $this->dispatch('refresh-list');
        \Toaster::success(__("User deleted successfully."));
        // $this->dispatch('navigate_to', route('admin.users.index'));
        // return $this->redirect(route('admin.users.index'), navigate: true);

    }

    #[On('statusUpdate')]
    public function statusUpdate(string $id){
     
        $user = auth()->user()->staffs()->findOrfail($id);
        $current_status = $user->status;
        $user->update(['status'=> $current_status == '0' ? '1' : '0']);
        $this->dispatch('refresh-list');
        \Toaster::success(__("User status change successfully."));
    }
}
