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

    #[On('refresh-list')]
    public function refresh() {}

    public function render(): View
    {
        $users = User::where(function ($query) {
                        $query->where('type', '=', 'admin')
                        ->orWhere('type', '=', 'staff');
                    })
                    ->paginate(10);
    
        return view('livewire.admin.users.index', compact('users'));
    }

}
