@extends('layouts.admin.dashboard')

@section('Display')
    @if (session('error'))
        <div class="alert alert-danger text-red-500 bg-red-100 border border-red-400 rounded p-4">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex flex-col space-y-6 w-full" id="admin-auctions">
        <h3 class="text-2xl font-semibold text-gray-800">Manage Auctions</h3>

        <div class="flex w-1/2 md:w-1/4">
            <form action="{{ route('admin.search.auction') }}" method="GET" class="relative w-full m-0">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input id="search-navbar" type="text" name="search" placeholder="Search..."
                    class="form-input text-sm w-full !pl-10" label="Search">
            </form>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300 text-left font-semibold">ID</th>
                        <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Title</th>
                        <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Owner</th>
                        <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Nº of Reported Auction</th>
                        <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Owner Username</th>
                        <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Owner Name</th>
                        <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Delete Auction</th>
                        <th class="px-4 py-2 border border-gray-300 text-left font-semibold">Cancel Auction</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($auctions as $auction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border border-gray-300">{{ $auction->id }}</td>
                            <td class="px-4 py-2 border border-gray-300">
                                <a href="{{ route('auctions.show', ['id' => $auction->id]) }}"
                                    class="text-blue-500 hover:underline">{{ $auction->title }}</a>
                            </td>
                            <td class="px-4 py-2 border border-gray-300">{{ $auction->owner_id }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $auction->report_count }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $auction->owner_username }}</td>
                            <td><a href="{{ route('user.profile.other', ['username' => $auction->owner_username]) }}"
                                    class="text-blue-500 hover:underline">{{ $auction->owner_name }}</a></td>
                            <td class="px-4 py-2 border border-gray-300 text-center">
                                <x-toast.confirm :buttonText="'Delete Auction'" :route="'auction.delete'" :method="'DELETE'" :id="'delete' . $auction->id"
                                    :modalTitle="'Delete this Auction?'" :modalMessage="'Are you sure you want to delete this? This action is irreversible.'" :object="$auction"
                                    class="px-4 py-2 text-white rounded-lg bg-red-700" />
                            </td>
                            <td class="px-4 py-2 border border-gray-300 text-center">
                                <x-toast.confirm :buttonText="'Cancel Auction'" :route="'auction.cancel_auction'" :method="'POST'" :id="'cancel_auction' . $auction->id"
                                    :modalTitle="'Cancel this Auction?'" :modalMessage="'Are you sure you want to cancel this auction? This action only works if no bidders exist.'" :object="$auction"
                                    class="px-4 py-2 text-white rounded-lg bg-red-500" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-gray-500">There are no Auctions.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $auctions->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
