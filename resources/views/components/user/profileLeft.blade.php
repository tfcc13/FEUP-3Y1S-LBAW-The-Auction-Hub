<div class="w-full p-4 md:p-6">
  <!-- User Profile Picture -->
  <div class="flex items-center justify-center h-48 mb-4 rounded overflow-hidden">
    <div class="w-48 h-48">
      <x-user.image :src="$user->profilePictureUrl" class="h-full w-full object-fill rounded"></x-user>
    </div>
  </div>
</div>

<div class="lg:m-5">
  <!-- User Details -->
  <div class="text-md font-bold text-gray-900 mb-2 sm:text-lg md:text-xl">
    <span class="mr-2">Name:</span>
    <span class="break-words">{{ $user->name }}</span>
  </div>

  <div class="text-md text-gray-500 font-bold mb-2 sm:text-lg md:text-xl">
    <span class="mr-2">Username:</span>
    <span class="break-words">{{ $user->username }}</span>
  </div>

  <div class="text-md text-gray-500 mb-4 sm:text-lg md:text-xl">
    <span class="mr-2 font-bold">Email:</span>
    <span class="break-words">{{ $user->email }}</span>
  </div>

  <!-- User Rating -->
  <div class="flex items-center text-gray-900 mb-4 sm:text-lg md:text-xl">
    <span class="mr-2 font-bold">Rating:</span>
    <div class="flex items-center">
      @php
      $rating = $user->rating ?? 0;
      $fullStars = floor($rating);
      $hasHalfStar = $rating - $fullStars >= 0.5;
      $emptyStars = 5 - ceil($rating);
      @endphp

      @for ($i = 0; $i < $fullStars; $i++)
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24" stroke="none">
        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
        </svg>
        @endfor

        @if ($hasHalfStar)
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24" stroke="none">
          <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
        </svg>
        @endif

        @for ($i = 0; $i < $emptyStars; $i++)
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
          </svg>
          @endfor
    </div>
  </div>

  <!-- User Description -->
  <div>
    <span class="text-md">Description:</span>
    <p>{{ $user->description ?? 'No description set' }}</p>
  </div>
</div>

@if (Auth::user()->is_admin)
<x-toast.confirm
  :buttonText="'Delete User'"
  :route="'admin.deleteUser'"
  :method="'DELETE'"
  :id="'delete'.$user->id"
  :modalTitle="'Delete this user?'"
  :modalMessage="'Are you sure you want to delete this? This action is irreversible.'"
  :object="$user" />
@if($user->state !== 'Banned')
<x-toast.confirm
  :buttonText="'Ban User'"
  :route="'admin.banUser'"
  :method="'PUT'"
  :id="'ban' .$user->id"
  :modalTitle="'Ban this user?'"
  :modalMessage="'Are you sure you want to delete this? '"
  :object="$user" />
<x-toast.confirm
  :buttonText="'Promote User'"
  :route="'admin.promoteUser'"
  :method="'PUT'"
  :id="'promote'.$user->id"
  :modalTitle="'Promote this user?'"
  :modalMessage="'Are you sure you want to delete this? This action is irreversible.'"
  :object="$user" />
@endif
@endif

