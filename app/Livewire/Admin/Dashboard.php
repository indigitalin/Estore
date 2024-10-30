<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    public bool $firstLogin = false;

    public function mount(): void
    {
        if (session('firstLogin', false)) {
            $this->firstLogin = true;
        }
    }

    public function render()
    {
        return view('livewire.admin.index');
    }

    #[On('welcome-message-shown')]
    public function welcomeMessageShown()
    {
        session(['firstLogin' => false]);
    }
}
