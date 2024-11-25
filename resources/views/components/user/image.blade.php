@if ($userImagePath)
    <img class="w-10 h-10 rounded-full"
         src="{{ asset('storage/' . $userImagePath) }}"
         alt="User Image">
@else
    <img class="w-20 h-20 rounded-full"
         src="{{ asset('default-avatar.png') }}"
         alt="Default Avatar">
@endif
