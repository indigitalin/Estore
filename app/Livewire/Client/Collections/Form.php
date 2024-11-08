<?php
namespace App\Livewire\Client\Collections;

use App\Livewire\Component;
use App\Models\{Role, Permission};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $collection;
    public \App\Livewire\Client\Collections\CollectionForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($collection = null): void
    {
        /**
         * Set collection if collection id is passed in route
         */
        if ($collection) {
            $this->form->setCollection($this->collection = auth()->user()->client->collections()->findOrfail($collection));
        }
    }

    public function render(): View
    {
        return view('livewire.client.collections.form')->withCollections(
            auth()->user()->client->collections()
            ->when($this->collection, fn($q) => $q->where('id', '!=', $this->collection->id))
            ->pluck('name', 'id')
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
