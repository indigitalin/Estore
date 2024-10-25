<?php
namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

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
    public function destroy(string $id)
    {
        auth()->user()->staffs()->findOrfail($id)->delete();
        \Toaster::success(__("User deleted successfully."));
    }

    #[On('status')]
    public function status(string $id)
    {
        $user = auth()->user()->staffs()->findOrfail($id);
        $user->update([
            'status' => $user->status == '0' ? '1' : '0',
        ]);
        \Toaster::success(__("User status updated successfully."));
    }
}
