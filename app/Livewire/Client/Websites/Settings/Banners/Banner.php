<?php

namespace App\Livewire\Client\Websites\Settings\Banners;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class Banner extends ModalComponent
{
    public $banner;
    public $website;

    public function mount(int $banner, int $website): void
    {
        $this->website = auth()->user()->client->websites()->findOrfail($website);
        $this->banner = $this->website->banners()->findOrfail($banner);
    }
    public function render(): View
    {
        return view('livewire.client.websites.settings.banners.banner');
    }
}
