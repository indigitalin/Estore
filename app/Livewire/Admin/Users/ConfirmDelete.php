<?php

namespace App\Http\Livewire\Admin\Users;
use App\Models\User;
use Livewire\Component;

class ConfirmDelete extends Component
{
    public $userIdToDelete;

    public function mount($userIdToDelete)
    {
        $this->userIdToDelete = $userIdToDelete;
    }

    public function delete()
    {
        User::destroy($this->userIdToDelete);
        $this->dispatch('refreshList');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function render()
    {
        return view('livewire.admin.users.confirm-delete');
    }
}
