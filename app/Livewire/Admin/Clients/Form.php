<?php
namespace App\Livewire\Admin\Clients;

use App\Livewire\Component;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $client;
    public \App\Livewire\Admin\Forms\ClientForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    public $states = []; // Add this to store the states
    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($client = null): void
    {
        /**
         * Set client if client id is passed in route
         */
        if ($client) {
            $this->form->setClient($this->client = Client::whereHas('user')->findOrfail($client));
            $this->updateStates(defaultState : $this->client->state_id); // Preload states if editing a client
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
        return view('livewire.admin.clients.form')->withCountries(
            \App\Models\Country::pluck('name','id')
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }

}
