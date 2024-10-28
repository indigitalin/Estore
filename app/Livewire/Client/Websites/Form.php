<?php
namespace App\Livewire\Client\Websites;

use App\Livewire\Component;
use App\Models\{Role, Permission};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $website;
    public \App\Livewire\Client\Websites\WebsiteForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;
    
    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($website = null): void
    {
        /**
         * Set website if website id is passed in route
         */
        if ($website) {
            $this->form->setWebsite($this->website = auth()->user()->client->websites()->findOrfail($website));
        }
    }

    public function render(): View
    {
        return view('livewire.client.websites.form');
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
