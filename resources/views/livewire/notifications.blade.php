<div>
    @forelse($notifications as $notification)
        <li class="px-4.5 py-3 hover:bg-gray-2">
            <strong>{{ $notification->subject }}</strong>
            <p>{{ $notification->description }}</p>
            <small>{{ $notification->updated_at->diffForHumans() }}</small>
        </li>
    @empty
        <li class="px-4.5 py-3 hover:bg-gray-2">
            Opps, no notification available
        </li>
    @endforelse
</div>
