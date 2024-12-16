<div class="flex flex-col space-y-6 w-full p-4 sm:p-6">
    {{-- Name --}}
    <h3 class="ml-10 my-4 text-2xl font-semibold text-gray-800">{{ $user->name }}</h3>

    <div
        class="grid grid-cols-1 sm:grid-cols-2 items-center justify-items-center sm:justify-items-start space-y-8 sm:space-y-0">
        <!-- User Profile Picture -->
        <div class="w-48 h-48 flex-shrink-0 items-center justify-center">
            <x-user.image :src="$user->profilePictureUrl" class="w-full h-full object-cover rounded-full" />
        </div>

        <!-- User Details and Rating -->
        <x-user.user-details :username="$user->username" :email="$user->email" :rating="$user->rating" />
    </div>

    <!-- Description Section -->
    <div class="flex flex-col space-y-4 border-t pt-6">
        <span class="text-xl font-semibold text-gray-900">Description</span>
        <p class="text-gray-700">{{ $user->description ?? 'No description set' }}</p>
    </div>


    <!-- Description Section -->
    <div class="border-t pt-6 flex flex-col items-center sm:flex-row space-y-4 sm:space-y-0 sm:space-x-8 ">
        @if (Auth::check() && Auth::user()->is_admin)
            <x-toast.confirm :buttonText="'Delete User'" :route="'admin.deleteUser'" :method="'DELETE'" :id="'delete' . $user->id" :modalTitle="'Delete this user?'"
                :modalMessage="'Are you sure you want to delete this? This action is irreversible.'" :object="$user" />
            @if ($user->state !== 'Banned')
                <x-toast.confirm :buttonText="'Ban User'" :route="'admin.banUser'" :method="'PUT'" :id="'ban' . $user->id"
                    :modalTitle="'Ban this user?'" :modalMessage="'Are you sure you want to ban this user, this will delete all there auction! '" :object="$user" />
                <x-toast.confirm :buttonText="'Promote User'" :route="'admin.promoteUser'" :method="'PUT'" :id="'promote' . $user->id"
                    :modalTitle="'Promote this user?'" :modalMessage="'Are you sure you want to delete this? This action is irreversible.'" :object="$user" />
            @else
                <x-toast.confirm :buttonText="'Unban User'" :route="'admin.unbanUser'" :method="'PUT'" :id="'unban' . $user->id"
                    :modalTitle="'Unban this user?'" :modalMessage="'Are you sure you want to unban the user? '" :object="$user" />
            @endif
        @endif

    </div>
</div>
