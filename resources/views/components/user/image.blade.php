@if ($userImagePath)
    <img class="{{ $classes }}"
         src="{{ asset('' . $userImagePath) }}"
         alt="User Image">
@else
    <img class="{{ $classes }}"
         src="{{ asset('default-avatar.png') }}"
         alt="Default Avatar">
@endif
