<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;

use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;

class UserModalView extends ModalComponent
{
    public ?User $user = null;
    public String $modalTitle;
    public String $maxWidthModal;

    public \App\Livewire\Admin\Forms\UsersForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;
  
    
    public function mount(User $user = null, $modalTitle = 'Default Title', $maxWidth = '2xl'): void
    {
        if ($user && $user->exists) {
            $this->form->setUser($user);
        }

        $this->modalTitle = $modalTitle;
        $this->maxWidthModal = $maxWidth;
    }


    public function render(): View
    {
  
        return view('livewire.admin.users.user-view', [
            'modalTitle' => $this->modalTitle,
            'maxWidthModal' => $this->maxWidthModal,
        ]);
    }

}