<?php

namespace App\Livewire;

use App\Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class ImageLibrary extends Component
{
    use WithFileUploads;
    public $product;
    protected $product_images = [];
    public $images = [];
    private $allowed_images = ['jpeg', 'jpg', 'png', 'webp'];
    public function mount($product = null): void
    {
        if ($product) {
            $this->product = $product;
            $this->product_images = $this->product->product_images->toArray();
        }
    }
    public function render()
    {
        return view('livewire.image-library')->withProductImages(
            $this->product_images
        );
    }

    public function updatedImages()
    {
        foreach ($this->images as $image) {
            $fileName = $image->getClientOriginalName();
            if ($image->isValid() && in_array($image->getClientOriginalExtension(), ['jpeg', 'jpg', 'png', 'webp'])) {
                // Check if the size is more than 2MB (2MB = 2097152 bytes)
                if ($image->getSize() > 2097152) {
                    // Handle the case when the image size is more than 2MB
                    // For example, you can throw an error or skip processing this image
                    $this->toasterError(__("{$fileName} is larger than 2mb."));
                } else {
                    $productImage = auth()->user()->client->product_images()->create([
                        'product_id' => $this->product->id ?? null,
                    ]);
                    $productImage->updateImage($image);

                    $this->dispatch('imageUploaded', [
                        'image' => $productImage,
                    ]);
                }
            } else {
                // Handle invalid image files (non-image files or unsupported file formats)
                $this->toasterError(__("{$fileName} is not an image."));
            }
        }
    }

    #[On('destroy')]
    public function destroy($id): void
    {
        auth()->user()->client->product_images()->findOrfail($id)->remove();
        $this->dispatch('imageDeleted', [
            'image_id' => $id,
        ]);
        $this->toasterSuccess(__("Image deleted successfully."));
    }
}
