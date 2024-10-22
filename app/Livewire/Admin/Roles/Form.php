<?php
namespace App\Livewire\Admin\Roles;

use App\Livewire\Component;
use App\Models\{Role, Permission};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $role;
    public \App\Livewire\Admin\Forms\UsersForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($role = null): void
    {
        if ($role) {
            $this->form->setRole($this->user = auth()->user()->staffs()->findOrfail($role));
        }
    }

    public function render(): View
    {
        return view('livewire.admin.roles.form')->withPermissions(
            Permission::whereType('admin')->get()->groupBy('section')
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->dispatch('refresh-list');
        $this->ToasterAlert($response);
        if($response['status'] == 'success')
        $this->dispatch('navigate_to', route('admin.users.index'));
    }

}
