@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Notifications</h1>
            @if($notifications->where('view_status', false)->count() > 0)
                <button onclick="markAllAsRead()" class="text-sm text-[#135d3b] hover:text-[#0f4a2f]">
                    Mark all as read
                </button>
            @endif
        </div>

        <div class="space-y-4">
            @forelse($notifications as $notification)
                <div class="bg-white rounded-lg shadow p-4 {{ $notification->view_status ? 'opacity-75' : '' }}"
                     data-notification-id="{{ $notification->id }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-gray-800">{{ $notification->content }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($notification->notification_date)->diffForHumans() }}
                            </p>
                        </div>
                        @if(!$notification->view_status)
                            <button onclick="markAsRead({{ $notification->id }})" 
                                    class="text-sm text-[#135d3b] hover:text-[#0f4a2f]">
                                Mark as read
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    No notifications to display
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.querySelector(`[data-notification-id="${id}"]`);
            notification.classList.add('opacity-75');
            notification.querySelector('button')?.remove();
        }
    });
}

function markAllAsRead() {
    fetch('/notifications/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection 