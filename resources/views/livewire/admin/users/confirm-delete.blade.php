
<div>
    <p>Are you sure you want to delete this user?</p>
    <button wire:click="delete">Yes, Delete</button>
    <button type="button" wire:click="$emit('closeModal')">Cancel</button>
</div>