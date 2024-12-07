@extends('layouts.app')

@section('content')
    <main class="flex flex-col items-center py-4 px-6 space-y-8">
        <!-- Categories Section -->
        <div id="categories-container" class="hidden w-full">
            <x-categories.categories :categories="$categories" />
        </div>

        <div
            class="flex flex-col sm:flex-row items-center justify-center w-full space-x-0 sm:space-x-6 space-y-2 sm:space-y-0">
            {{-- Search Results Title --}}
            <h1 class="text-2xl sm:text-4xl sm:font-semibold text-gray-800 text-center whitespace-nowrap">Search Results</h1>

            <!-- Toggle Buttons -->
            <input type="checkbox" id="toggle" class="toggleCheckbox hidden peer" />
            <label for="toggle"
                class="toggleContainer grid grid-cols-2 w-56 border border-[#135d3b] cursor-pointer relative rounded-2xl before:rounded-2xl 
                before:bg-[#135d3b] before:absolute before:top-0 before:left-0 before:w-1/2 before:h-full before:transition-all before:duration-300 before:content-[''] *:text-center *:z-10 *:px-2 *:py-1 *:transition-colors *:duration-300 peer-checked:before:left-1/2">
                <div id="toggle-auctions">
                    Auctions</div>
                <div id="toggle-users">
                    Users</div>
            </label>
        </div>

        <!-- Error or Message Section -->
        @if (isset($error))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <p class="font-bold">Error</p>
                <p>{{ $error }}</p>
            </div>
        @elseif(isset($message))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded mb-6">
                <p>{{ $message }}</p>
            </div>
        @endif

        <!-- Results Container -->
        <div id="results-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"></div>

        <!-- Template for auction item -->
        <template id="auction-item-template">
            <x-slide.slide-item :title="''" :currentBid="0" :imageUrl="''" :buttonAction="''" :endDate="''"
                :searchResults="true" />
        </template>
    </main>

    <script>
        document.querySelectorAll('[data-category]').forEach(button => {
            button.addEventListener('click', () => {
                const categoryId = button.getAttribute('data-category');
                setActiveButton(button.id);
                fetchResults('auctions', categoryId); // Pass the selected category ID
            });
        });

        document.getElementById('toggle-auctions').addEventListener('click', () => {
            setActiveButton('toggle-auctions');

            document.getElementById('categories-container').classList.remove('hidden'); // Show categories
            fetchResults('auctions');
        });

        document.getElementById('toggle-users').addEventListener('click', () => {
            setActiveButton('toggle-users');
            document.getElementById('categories-container').classList.add('hidden'); // Hide categories
            fetchResults('users');
        });

        async function fetchResults(type, categoryId = '') {
            try {
                const searchTerm = '{{ $searchTerm }}';
                let url = `/api/${type}/search?search=${encodeURIComponent(searchTerm)}`;
                if (categoryId) {
                    url += `&category=${categoryId}`; // Append category filter to URL
                }

                const response = await fetch(url);


                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Error:', errorData.error || 'Something went wrong');
                    document.getElementById('results-container').innerHTML =
                        `<p class="text-red-500">${errorData.error || 'Failed to reach the server'}</p>`;
                    return;
                }

                const {
                    data,
                    message
                } = await response.json();
                if (data.length === 0) {
                    document.getElementById('results-container').innerHTML =
                        `<p class="text-gray-600">${message || `No ${type} results found.`}</p>`;
                    return;
                }

                displayResults(data, type);

            } catch (error) {
                // Catch unexpected errors, such as network issues
                console.error('Unexpected error:', error);
                document.getElementById('results-container').innerHTML =
                    `<p class="text-red-500">An unexpected error occurred.</p>`;
            }
        }

        function displayResults(results, type) {
            const container = document.getElementById('results-container');
            container.innerHTML = '';

            if (!results.length) {
                container.innerHTML = `<p class="text-gray-600">No ${type} results found.</p>`;
                return;
            }

            results.forEach(item => {
                if (type === 'auctions') {
                    // Clone the template
                    const template = document.getElementById('auction-item-template');
                    const clone = template.content.cloneNode(true);

                    // Update the component's attributes
                    const component = clone.querySelector('article');
                    if (component) {
                        // Update title
                        component.querySelector('.auction-title span').textContent = item.title;

                        // Update end date
                        component.querySelector('[aria-label="End date"]').textContent =
                            `${new Date(item.end_date).toLocaleString('en-US', {month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit'})}`;

                        // Update current bid - using the first bid amount or start price if no bids
                        const currentBid = item.bids && item.bids.length > 0 ? item.bids[0].amount : item
                            .start_price;
                        component.querySelector('[aria-label="Current bid amount"]').textContent =
                            `$${Number(currentBid).toFixed(2)}`;

                        // Update image using primaryImage
                        const imageUrl = item.primaryImage;
                        component.querySelector('img').src = imageUrl;
                        component.querySelector('img').alt = `Auction item: ${item.title}`;

                        // Replace button with an anchor tag
                        const button = component.querySelector('button');
                        const link = document.createElement('a');
                        link.href = `/auctions/auction/${item.id}`;
                        link.className = button.className; // Copy all the button's classes
                        link.textContent = 'Bid Now';
                        link.setAttribute('role', 'button');
                        button.replaceWith(link);
                    }

                    container.appendChild(clone);
                } else {
                    const userCard = `<div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-3">${item.name}</h2>
                            <p class="text-gray-600 mb-4">Username: ${item.username}</p>
                            <a href="/profile/${item.username}" class="inline-block px-4 py-2 text-white sm:text-base rounded-md bg-[#135d3b] hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View Profile
                            </a>
                        </div>
                    </div>`;
                    container.innerHTML += userCard;
                }
            });
        }
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('categories-container').classList.remove('hidden'); // Show categories
            fetchResults('auctions'); // Default search type is 'auctions'
        });

        function setActiveButton(activeButtonId) {
            const buttons = document.querySelectorAll('.toggle-btn'); // Select both buttons

            buttons.forEach(button => {
                if (button.id === activeButtonId) {
                    button.classList.add('bg-opacity-80'); // Highlight the selected button
                    button.classList.remove('hover:bg-opacity-100');
                } else {
                    button.classList.remove('bg-opacity-80'); // Remove highlight from unselected button
                    button.classList.add('hover:bg-opacity-100');
                }
            });
        }
    </script>


    <style>
        .toggleCheckbox:checked+.toggleContainer div:first-child {
            color: #343434;
        }

        .toggleCheckbox:checked+.toggleContainer div:last-child {
            color: white;
        }

        .toggleCheckbox+.toggleContainer div:last-child {
            color: #343434;
        }

        .toggleCheckbox+.toggleContainer div:first-child {
            color: white;
        }
    </style>
@endsection
