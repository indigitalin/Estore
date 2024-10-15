<?php

namespace App\Livewire\Admin\Users;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\User;
use Livewire\WithPagination;

use Illuminate\Contracts\View\View;

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUser;
    public $userIdToDelete;

    protected $listeners = ['refreshList' => '$refresh'];

    public function render()
    {
        $users = User::where('firstname', 'like', '%' . $this->search . '%')
                     ->orWhere('email', 'like', '%' . $this->search . '%')
                     ->paginate(10);

        return view('livewire.admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->dispatch('openModal', ['component' => 'admin.users.user-modal-component']);
    }

    public function edit($id)
    {
        $this->selectedUser = User::find($id);
        $this->dispatch('openModal', ['component' => 'admin.users.user-modal-component', 'user' => $this->selectedUser]);
    }

    public function confirmDelete($id)
    {
        $this->userIdToDelete = $id;
        $this->dispatch('openModal', ['component' => 'admin.users.confirm-delete']);
    }

    public function delete()
    {
        User::destroy($this->userIdToDelete);
        $this->userIdToDelete = null;
        $this->dispatch('refreshList');
    }
}





// use LivewireUI\Modal\ModalComponent;

// class UserModal extends ModalComponent
// {
   
//     public $count = 1;
 
//     public function increment()
//     {
//         $this->count++;
//     }
 
//     public function decrement()
//     {
//         $this->count--;
//     }

//     #[On('refresh-list')]
//     public function refresh() {}

//     public function render(): View
//     {
//         $users = ModelsUser::
//                         // where(function ($query) {
//                         //     $query->where('type', '=', 'admin')
//                         //           ->orWhere('type', '=', 'admin-staff');
//                         // })->
//                         get();

//         return view('livewire.admin.users.index',)->with(compact('users'));
//     }

    
// }
