<?php
namespace App\Livewire\Client\Websites;

use App\Livewire\Component;
use App\Models\Website;

class Settings extends Component
{
    public $website;

    public function mount(Website $website = null): void
    {
        auth()->user()->client->websites()->findOrfail($website->id);
    }

    public function render()
    {
        return view('livewire.client.websites.settings');
    }
}
