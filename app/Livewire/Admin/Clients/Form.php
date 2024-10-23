<?php
namespace App\Livewire\Admin\Clients;

use App\Livewire\Component;
use App\Models\{User, Client};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $client;
    public \App\Livewire\Admin\Forms\ClientForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($client = null): void
    {
        if ($client) {
            $this->form->setClient($this->client = Client::findOrfail($client));
        }
    }

    public function render(): View
    {
        return view('livewire.admin.clients.form');
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }

}
