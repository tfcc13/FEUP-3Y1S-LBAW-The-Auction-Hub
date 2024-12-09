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
        @if (Auth::user()->is_admin)
            <x-toast.delete.confirmation :route="'admin.deleteUser'" :button="'Delete User'" :object="$user" :id="'del'" />
            <x-toast.put.confirmation :route="'admin.banUser'" :button="'Ban User'" :object="$user" :id="'ban'" />
            <x-toast.put.confirmation :route="'admin.promoteUser'" :button="'Turn Admin'" :object="$user" :id="'promote'" />
        @endif
        <x-toast.post.confirmation :route="'user.banUserRequest'" :button="'Request Ban'" :object="$user" :id="'banRequest'" />
    </div>
</div>
