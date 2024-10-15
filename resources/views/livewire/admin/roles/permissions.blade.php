<div class="p-6">
    <div class="text-xl font-semibold mb-5">{{ $this->role->name }} permissions</div>
    @forelse ($this->role->permissions()->get()->groupBy('section') as $section => $items)
        <div class="mb-4">
            <div class="font-medium text-md">{{ $section }}</div>
            @foreach ($items as $item)
                <div class="">{{ $item->name }}</div>
            @endforeach
        </div>
    @empty
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            Opps no permissions set for <span class="font-medium">{{ $this->role->name }}</span>
        </div>
    @endforelse
</div>
