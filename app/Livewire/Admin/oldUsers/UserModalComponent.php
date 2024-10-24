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
    public String $maxWidthModal;

    public \App\Livewire\Admin\Forms\UserForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;
  
    
    public function mount(User $user = null): void
    {
        if ($user && $user->exists) {
            $this->form->setUser($user);
        }
    }



    public function save(): void
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }

    public function render(): View
    {
  
        return view('livewire.admin.users.user-modal');
    }

    private function toasterAlert(array $msg){
        $this->closeModal();
        $this->dispatch('refresh-list');
        if($msg['status'] == 'success'){
            \Toaster::success($msg['message']);
        }
        else{
            \Toaster::error($msg['message']);
        }
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

   

}
