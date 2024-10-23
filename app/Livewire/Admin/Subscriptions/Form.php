<?php
namespace App\Livewire\Admin\Subscriptions;

use App\Livewire\Component;
use App\Models\{Module,Plan};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Form extends Component
{
    public $plan;
    public \App\Livewire\Admin\Forms\SubscriptionForm $form;

    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($plan = null): void
    {
        if ($plan) {
            Plan::findOrfail($plan);
        }
    }

    public function render(): View
    {
        return view('livewire.admin.subscriptions.form')->withModules(
            Module::where('status',1)->select('name','handle','id')->get()
        );
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }
}
