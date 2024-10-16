<div class="p-6">
    <div class="text-xl font-semibold mb-5">Heads up!</div>
    <form wire:submit="destroy">
        <p>Are you sure want to delete the role?</p>
        <div class="mt-5 flex">
            <x-secondary-button type="button" wire:click="$dispatch('closeModal')" class="ms-auto me-2">
                No, cancel
            </x-secondary-button>
            <x-danger-button type="submit">
                Yes, continue
            </x-danger-button>
        </div>
    </form>
</div>
