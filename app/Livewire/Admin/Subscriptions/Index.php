<?php
namespace App\Livewire\Admin\Subscriptions;

use Livewire\Component;
use App\Models\{Plan};
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.subscriptions.index')->withPlans(
            Plan::paginate(10)
        );
    }

    #[On('destroy')]
    public function destroy(string $id){
        Plan::findOrfail($id)->delete();
        \Toaster::success(__("Plan deleted successfully."));
    }

    #[On('status')]
    public function status(string $id){
     
        $plan = Plan::findOrfail($id);
        $plan->update([
            'status'=> $plan->status == '0' ? '1' : '0'
        ]);
        \Toaster::success(__("Plan status updated successfully."));
    }
}
