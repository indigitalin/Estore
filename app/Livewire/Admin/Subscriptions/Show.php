<?php
namespace App\Livewire\Admin\Subscriptions;

use Livewire\Component;
use App\Models\Plan;

class Show extends Component
{
    public $plan;

    
    public \App\Livewire\Admin\Forms\SubscriptionForm $form;
    
    public function mount(Plan $plan = null): void
    {
        if ($plan && $plan->exists) {
            $this->form->setSubscription($plan);
        
        }
    }


    public function render()
    {
  
        return view('livewire.admin.subscriptions.show');
    }
}
