<?php
namespace App\Livewire\Admin\Users;

use App\Livewire\Component;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $user;
    public \App\Livewire\Admin\Forms\UsersForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($user = null): void
    {
        if ($user) {
            $this->user = User::findorFail($user);
            $this->form->setUser($this->user);
        }
    }

    public function render(): View
    {
        return view('livewire.admin.users.form');
    }

    public function save()
    {
        $response = $this->form->save();
        $this->dispatch('refresh-list');
        $this->ToasterAlert($response);
        $this->dispatch('navigate_to', route('admin.users.index'));
    }
}
