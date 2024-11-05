<?php

namespace App\Livewire\Client\Websites\Settings\Banners;

use App\Livewire\Component;
use App\Models\{Website, Banner};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public $website;
    public $banner;
    public \App\Livewire\Client\Websites\Settings\Banners\BannerForm $form;
    
    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($website = null, $banner = null): void
    {   
        $this->form->setWebsite($this->website = auth()->user()->client->websites()->findOrfail($website));
        /**
         * Set banner if banner id is passed in route
         */
        if ($banner) {
            $this->form->setBanner($this->banner = $this->website->banners()->findOrfail($banner));
        }
    }

    public function render(): View
    {
        return view('livewire.client.websites.settings.banners.form');
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
