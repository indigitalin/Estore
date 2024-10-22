<?php
namespace App\Livewire\Admin\Users;

use App\Livewire\Component;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $user;
    public \App\Livewire\Admin\Forms\UserForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($user = null): void
    {
        if ($user) {
            $this->form->setUser($this->user = auth()->user()->staffs()->findOrfail($user));
        }
    }

    public function render(): View
    {
        return view('livewire.admin.users.form')->withRoles(
            Role::adminRoles()->pluck('name','id')
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->dispatch('refresh-list');
        $this->ToasterAlert($response);
        if($response['status'] == 'success'){
            return $this->redirect(route('admin.users.index'), navigate: true);
        }
        // $this->dispatch('navigate_to', route('admin.users.index'));
    }
}
