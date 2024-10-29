<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class Notifications extends Component
{
    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notification::where('user_id', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
