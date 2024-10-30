<?php

namespace App\Livewire\Client;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class GetStarted extends ModalComponent
{

    public function render(): View
    {
        return view('livewire.client.get-started');
    }
}