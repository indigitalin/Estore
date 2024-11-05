<?php
namespace App\Livewire\Client\Websites\Settings\Menus;

use App\Livewire\Form;
use App\Models\{Menu, Website};
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class MenuForm extends Form
{
    public ?Menu $menu = null;
    public ?Website $website = null;
    public string|null $title = null;

    public function setWebsite(?Website $website = null): void
    {
        $this->website = $website;
    }

    public function setMenu(?Menu $menu = null): void
    {
        $this->menu = $menu;
        $this->title = $menu->title ;
    }

    public function save()
    {
        $this->prepareValidation();
        $this->validate();
        try {
            if ($this->menu) {
                // Update existing menu
                $this->menu->update($this->only([
                    'title', 'slug'
                ]));
            } else {
                // Create new menu
                $this->menu = $this->website->menus()->create($this->only([
                    'title', 'slug'
                ]));
            }
            return ([
                'status' => 'success',
                'message' => $this->menu->wasRecentlyCreated ? 'Menu created successfully.' : 'Menu updated successfully.',
                'redirect' => route('client.websites.settings.menus.index', $this->website),
            ]);

        } catch (\Exception $e) {

            return $this->error($e);
        }
    }

    /**
     * Before validation, prepare the values and do necessary changes
     */
    public function prepareValidation(): void
    {
        $this->slug = \Illuminate\Support\Str::slug($this->title);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:128', function ($attribute, $value, $fail) {
                $exists = $this->website->menus()->whereTitle($value)
                    ->whereNot('id', $this->menu->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The menu already exists, please create different one.');
                }
            }],
        ];
    }
}
