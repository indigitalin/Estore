<?php

namespace App\Livewire;

use App\Livewire\Component;
use Livewire\Attributes\On;

class ImageLibrary extends Component
{
    public string $type;
    public function mount(string $type): void
    {
        $this->type = $type;
    }
    public function render()
    {
        return view('livewire.image-library')->withAttachments(
            auth()->user()->client->attachments
        );
    }

    #[On('destroy')]
    public function destroy($id): void
    {
        auth()->user()->client->attachments()->findOrfail($id)->delete();
        $this->dispatch('attachmentDeleted', [
            'attachment_id' => $id,
        ]);
        $this->toasterSuccess(__("Attachment deleted successfully."));
    }
}
