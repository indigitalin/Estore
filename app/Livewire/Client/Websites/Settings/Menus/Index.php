<?php
namespace App\Livewire\Client\Websites\Settings\Menus;

use App\Livewire\Component;
use App\Models\Website;
use Livewire\Attributes\On;

class Index extends Component
{
    public $website;

    public function mount(Website $website = null): void
    {
        auth()->user()->client->websites()->findOrfail($website->id);
    }

    public function render()
    {
        return view('livewire.client.websites.settings.menus.index')->withMenus(
            $this->website->menus()->paginate(20)
        );
    }

    #[On('destroy')]
    public function destroy(string $id){
        $this->website->menus()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Menu deleted successfully."));
    }
}
