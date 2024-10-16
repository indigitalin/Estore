<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;

use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;

class UserModalComponent extends ModalComponent
{
    public ?User $user = null;
    public String $modalTitle;
    public String $maxWidth;

    public \App\Livewire\Admin\Forms\UsersForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;
    public function mount(User $user = null,$modalTitle = "",$maxWidth = ""): void
    {
        if ($user->exists) {
            $this->form->setUser($user);
        }
        $this->modalTitle = $modalTitle;
        $this->maxWidth = $maxWidth;
    }



    public function save(): void
    {
        $response = $this->form->save();
        $this->ToasterAlert($response);
    }

    public function render(): View
    {
    
        return view('livewire.admin.users.user-modal');
    }

    private function ToasterAlert(array $msg){
        $this->closeModal();
        $this->dispatch('refresh-list');
        if($msg['status'] == 'success'){
            \Toaster::success($msg['message']);
        }
        else{
            \Toaster::error($msg['message']);
        }
    }

}
