<?php

namespace App\Livewire\Client\Websites\Settings\Menus;

use App\Livewire\Component;
use App\Models\{Website, Menu};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;

class Form extends Component
{
    public $website;
    public $menu;
    public \App\Livewire\Client\Websites\Settings\Menus\MenuForm $form;
    
    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($website = null, $menu = null): void
    {   
        $this->form->setWebsite($this->website = auth()->user()->client->websites()->findOrfail($website));
        /**
         * Set menu if menu id is passed in route
         */
        if ($menu) {
            $this->form->setMenu($this->website->menus()->findOrfail($menu));
        }
    }

    public function render(): View
    {
        return view('livewire.client.websites.settings.menus.form');
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
