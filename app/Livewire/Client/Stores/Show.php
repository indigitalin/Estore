<?php
namespace App\Livewire\Client\Stores;

use App\Livewire\Component;
use App\Models\Store;

class Show extends Component
{
    public $store;

    public \App\Livewire\Admin\Forms\StoreForm $form;

    public function mount(Store $store = null): void
    {
        auth()->user()->client->stores()->findOrfail($store->id);
    }

    public function render()
    {
        return view('livewire.client.stores.show');
    }
}
