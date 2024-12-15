@extends('layouts.admin.dashboard')

@section('Display')
<!-- Main Content -->
@if(session('error'))
<div class="alert alert-danger text-red-500 bg-red-100 border border-red-400 rounded p-4">
  {{ session('error') }}
</div>
@endif
<div class="container mx-auto p-6">
  <h2 class="text-xl font-semibold mb-4">Manage Transactions</h2>

  <!-- Responsive Table Wrapper -->
  <div class="mt-4 overflow-x-auto">
    <table class="min-w-full table-auto border-collapse border border-gray-200">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border border-gray-300 text-left font-semibold">ID</th>
          <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Name</th>
          <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Username</th>
          <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Nº of Reported Auction</th>
          <th class="px-4 py-2 border border-gray-300 text-center font-semibold">Ban</th>
          <th class="px-4 py-2 border border-gray-300 text-center font-semibold">Delete</th>
          <th class="px-4 py-2 border border-gray-300 text-center font-semibold">Promote</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse ($users as $user)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-2 border border-gray-300">{{ $user->id }}</td>
          <td class="px-4 py-2 border border-gray-300">
            <a href="{{ route('user.profile.other', ['username' => $user->username]) }}" class="text-blue-500 hover:underline">{{ $user->name }}</a>
          </td>
          <td class="px-4 py-2 border border-gray-300">{{ $user->username }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ $user->report_count }}</td>
          <td class="px-4 py-2 border border-gray-300 text-center">
            @if($user->state !== 'Banned')
            <x-toast.confirm
              :buttonText="'Ban User'"
              :route="'admin.banUser'"
              :method="'PUT'"
              :id="'ban' .$user->id"
              :modalTitle="'Ban this user?'"
              :modalMessage="'Are you sure you want to ban this user, this will delete all their auction!'"
              :object="$user" />
            @else
            <x-toast.confirm
              :buttonText="'Unban User'"
              :route="'admin.unbanUser'"
              :method="'PUT'"
              :id="'unban' .$user->id"
              :modalTitle="'Unban this user?'"
              :modalMessage="'Are you sure you want to unban the user?'"
              :object="$user" />
            @endif
          </td>
          <td class="px-4 py-2 border border-gray-300 text-center">
            <x-toast.confirm
              :buttonText="'Delete User'"
              :route="'admin.deleteUser'"
              :method="'DELETE'"
              :id="'delete'.$user->id"
              :modalTitle="'Delete this user?'"
              :modalMessage="'Are you sure you want to delete this user? This action is irreversible.'"
              :object="$user" />
          </td>
          <td class="px-4 py-2 border border-gray-300 text-center">
            @if($user->state !== 'Banned')
            <x-toast.confirm
              :buttonText="'Promote User'"
              :route="'admin.promoteUser'"
              :method="'PUT'"
              :id="'promote'.$user->id"
              :modalTitle="'Promote this user?'"
              :modalMessage="'Are you sure you want to delete this? This action is irreversible.'"
              :object="$user" />
            @else
            <p>The user is banned.</p>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-4 py-2 text-center text-gray-500">You have no reports.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
</div>
@endsection
