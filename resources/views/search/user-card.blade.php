@props(['name', 'username'])

<div class="bg-white  rounded-lg shadow-md space-y-4 p-5 ">
    <header aria-label="User Name">
        <span class="text-gray-800 text-lg font-semibold select-none line-clamp-1">
            {{ $name }}
        </span>
    </header>

    <div class="flex items-baseline gap-3">
        <span class="font-medium">Username: </span>
        <span class="text-gray-600 select-none text-lg" aria-label="Username">
            {{ $username }}
        </span>
    </div>

    <button
        class="text-white px-3 py-1 rounded border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95 select-none"
        aria-label="View {{ $name }} Profile" onclick="window.location.href='/profile/{{ $username }}'">
        View Profile
    </button>
</div>
