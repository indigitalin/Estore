<?php
namespace App\Livewire\Client\Categories;

use App\Livewire\Component;
use App\Models\{Role, Permission};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $category;
    public \App\Livewire\Client\Categories\CategoryForm $form;
    use \App\Helper\Upload;
    use WithFileUploads;

    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($category = null): void
    {
        /**
         * Set category if category id is passed in route
         */
        if ($category) {
            $this->form->setCategory($this->category = auth()->user()->client->categories()->findOrfail($category));
        }
    }

    public function render(): View
    {
        return view('livewire.client.categories.form')->withCategories(
            auth()->user()->client->categories()
            ->when($this->category, fn($q) => $q->where('id', '!=', $this->category->id))
            ->pluck('name', 'id')
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
