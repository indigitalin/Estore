<?php
namespace App\Livewire\Client\Websites\Settings\Banners;

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
        return view('livewire.client.websites.settings.banners.index')->withBanners(
            $this->website->banners()->paginate(20)
        );
    }

    #[On('status')]
    public function status(string $id){
        $banner = $this->website->banners()->findOrfail($id);
        $banner->update([
            'status' => $banner->status == '0' ? '1' : '0',
        ]);
        $this->toasterSuccess(__("Banner status updated successfully."));
    }

    #[On('destroy')]
    public function destroy(string $id){
        $this->website->banners()->findOrfail($id)->delete();
        $this->toasterSuccess(__("Banner deleted successfully."));
    }
}
