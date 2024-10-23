<?php
namespace App\Livewire\Admin\Clients;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.clients.index')->withClients(
            Client::paginate(10)
        );
    }

    #[On('destroy')]
    public function destroy(string $id){
        //auth()->user()->staffs()->findOrfail($id)->delete();
        \Toaster::success(__("User deleted successfully."));
    }

    #[On('status')]
    public function status(string $id){
        $client = Client::findOrfail($id);
        $client->update([
            'status'=> $client->status == '0' ? '1' : '0'
        ]);
        $client->user->update([
            'status'=> $client->status,
        ]);
        \Toaster::success(__("User status updated successfully."));
    }
}
