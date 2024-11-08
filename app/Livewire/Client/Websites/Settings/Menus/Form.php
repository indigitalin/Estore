<?php

namespace App\Livewire\Client\Websites\Settings\Menus;

use App\Livewire\Component;
use App\Models\Menu;
use App\Models\Website;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;

class Form extends Component
{
    public $website;
    public $menu;
    public \App\Livewire\Client\Websites\Settings\Menus\MenuForm $form;

    protected $listeners = ['refreshList' => '$refresh'];

    #[On('refresh-list')]
    public function refresh()
    {}

    public function mount($website = null, $menu = null): void
    {
        $this->form->setWebsite($this->website = auth()->user()->client->websites()->findOrfail($website));
        /**
         * Set menu if menu id is passed in route
         */
        if ($menu) {
            $this->form->setMenu($this->menu = $this->website->menus()->findOrfail($menu));
        }
    }

    public function render(): View
    {
        return view('livewire.client.websites.settings.menus.form')->withMenus(
            $this->menu ? \App\Http\Resources\MenuResource::collection($this->menu->childs) : collect([])
        )->withLinks($this->links());
    }

    public function save()
    {
        $response = $this->form->save();
        $this->toasterAlert($response);
    }

    #[On('set-menus')]
    public function setMenus($menus)
    {
        $this->form->menus = $menus;
    }

    /**
     * Generate fixed links based on pages and categories
     */
    public function links(): array
    {
        $links = $categories = $pages = [];
        foreach ($this->website->pages as $page) {
            $pages[] = [
                'title' => $page->title,
                'link' => "/pages/{$page->slug}",
            ];
        }

        foreach (auth()->user()->client->categories as $category) {
            $categories[] = [
                'title' => $category->name,
                'link' => "/pages/{$category->handle}",
            ];
        }

        return [
            [
                'title' => 'Pages',
                'menus' => $pages,
            ], [
                'title' => 'Categories',
                'menus' => $categories,
            ],
        ];
    }
}
