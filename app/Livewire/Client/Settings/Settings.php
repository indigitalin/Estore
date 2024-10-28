<?php

namespace App\Livewire\Client\Settings;

use App\Models\Client;
use \App\Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    public Client $client;
    public \App\Livewire\Client\Settings\SettingsForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    public $states = []; // Add this to store the states

    public function mount(): void
    {
        $this->form->setClient($this->client = auth()->user()->client);
        $this->updateStates(defaultState : $this->client->state_id); // Preload states if editing a client

        /**
         * Hardcode country states of application runs for single country
         */
        if(config('app.country')){
            $this->states = \App\Models\State::whereCountryId(config('app.country'))->pluck('name','id');
        }
    }

    // Method to update the states based on the selected country
    public function updateStates($defaultState = null)
    {
        $this->states = \App\Models\State::whereCountryId($this->form->country_id)->pluck('name','id');

        // Clear state selection if the country changes
        $this->form->state_id = $defaultState;
    }

    public function render()
    {
        return view('livewire.client.settings.settings')->withCountries(
            \App\Models\Country::pluck('name','id')
        )->withIndustries(
            \App\Models\Industry::active()->pluck('name', 'id')
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
