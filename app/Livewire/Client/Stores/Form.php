<?php
namespace App\Livewire\Client\Stores;

use App\Livewire\Component;
use App\Models\{Role, Permission};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $store;
    public \App\Livewire\Client\Stores\StoreForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    public $states = []; // Add this to store the states
    
    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($store = null): void
    {
        /**
         * Set store if store id is passed in route
         */
        if ($store) {
            $this->form->setStore($this->store = auth()->user()->client->stores()->findOrfail($store));
            $this->updateStates(defaultState : $this->store->state_id); // Preload states if editing a client
        }
    }

    // Method to update the states based on the selected country
    public function updateStates($defaultState = null)
    {
        $this->states = \App\Models\State::whereCountryId($this->form->country_id)->pluck('name','id');

        // Clear state selection if the country changes
        $this->form->state_id = $defaultState;
    }

    public function render(): View
    {
        return view('livewire.client.stores.form')->withCountries(
            \App\Models\Country::pluck('name','id')
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
