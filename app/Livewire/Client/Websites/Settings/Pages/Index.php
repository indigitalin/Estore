<?php
namespace App\Livewire\Client\Websites\Settings\Pages;

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
        return view('livewire.client.websites.settings.pages.index')->withPages(
            $this->website->pages()->paginate(20)
        );
    }

    #[On('status')]
    public function status(string $id){
        $page = $this->website->pages()->findOrfail($id);
        $page->update([
            'status' => $page->status == '0' ? '1' : '0',
        ]);
        $this->toasterSuccess(__("Banner status updated successfully."));
    }

    #[On('destroy')]
    public function destroy(string $id){
        $this->website->pages()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Page deleted successfully."));
    }
}
