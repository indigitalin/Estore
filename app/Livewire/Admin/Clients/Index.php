<?php
namespace App\Livewire\Admin\Clients;

use App\Models\Client;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        /**
         * Prevent loading client who have no admin.
         * This potentially cause errors while loading informations
         */
        return view('livewire.admin.clients.index')->withClients(
            Client::whereHas('user')->paginate(10)
        );
    }

    #[On('destroy')]
    public function destroy(string $id)
    {
        $client = Client::findOrfail($id);
        /**
         * Delete everything related to clients
         * Everything? Yes everything
         */
        $client->user->staffs()->delete();
        $client->user()->delete();
        $client->delete();
        \Toaster::success(__("User deleted successfully."));
    }

    #[On('status')]
    public function status(string $id)
    {
        $client = Client::findOrfail($id);
        /**
         * Change status of client and client admin
         * So they can not login to client is disabled.
         */
        $client->update([
            'status' => $client->status == '0' ? '1' : '0',
        ]);
        $client->user->update([
            'status' => $client->status,
        ]);
        \Toaster::success(__("User status updated successfully."));
    }
}
