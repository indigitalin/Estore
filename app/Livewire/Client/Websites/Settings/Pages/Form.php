<?php

namespace App\Livewire\Client\Websites\Settings\Pages;

use App\Livewire\Component;
use App\Models\{Website, Page};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;

class Form extends Component
{
    public $website;
    public $page;
    public \App\Livewire\Client\Websites\Settings\Pages\PageForm $form;
    
    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($website = null, $page = null): void
    {   
        $this->form->setWebsite($this->website = auth()->user()->client->websites()->findOrfail($website));
        /**
         * Set page if page id is passed in route
         */
        if ($page) {
            $this->form->setPage($this->page = $this->website->pages()->findOrfail($page));
        }
    }

    public function render(): View
    {
        return view('livewire.client.websites.settings.pages.form')->withBanners(
            collect($this->website->banners()->breadcrumb()->selectRaw(
                'id as value, title as label, desktop as image'
            )->get()->toArray())
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
