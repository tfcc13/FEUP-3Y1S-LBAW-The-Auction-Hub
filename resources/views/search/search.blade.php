@extends('layouts.app')

@section('content')
    <main class="flex flex-col sm:flex-row w-full h-screen overflow-hidden">
        <aside id="categories-container" class="bg-gray-100 w-full sm:w-64 h-full p-4 overflow-y-auto">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Filters</h2>
            <nav aria-label="Product Categories" class="space-y-2" role="list">
                @foreach ($categories as $category)
                    <div id="{{ $category->id }}" class="flex flex-col items-start" role="listitem">
                        <button class="w-full text-left p-2 rounded bg-transparent hover:bg-gray-200"
                            aria-label="{{ $category->name }}" title="{{ $category->name }}" id="{{ $category->id }}"
                            data-category="{{ $category->id }}">
                            {{ $category->name }}
                        </button>
                    </div>
                @endforeach
            </nav>
        </aside>

        <div class="flex-1 flex flex-col items-center py-4 px-6 space-y-8 overflow-y-auto">

            <!-- Header Section -->
            <div
                class="flex flex-col sm:flex-row items-center justify-center w-full space-x-0 sm:space-x-6 space-y-2 sm:space-y-0">
                <h1 class="text-2xl sm:text-4xl sm:font-semibold text-gray-800 text-center whitespace-nowrap">Search Results
                </h1>

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

            <!-- Error Message Section -->
            <div id="error-message"
                class="absolute top-[40%] flex flex-col items-center text-gray-800 text-2xl space-y-4 error-message"
                style="display: none;">
                <span class="material-symbols-outlined" style="font-size: 9rem; font-weight: 200;">search_off</span>
                <p></p>
            </div>

            <!-- Results Container -->
            <div id="results-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @if (isset($error) || isset($message))
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const errorMessage = document.getElementById('error-message');
                            errorMessage.style.display = 'flex';
                            errorMessage.querySelector('p').textContent = '{{ $error ?? $message }}';
                            document.getElementById('results-container').style.display = 'none';
                        });
                    </script>
                @endif
            </div>

            <!-- Template for user card -->
            <template id="user-card-template">
                @include('search.user-card', ['name' => '', 'username' => ''])
            </template>

            <!-- Template for auction item -->
            <template id="auction-item-template">
                <x-slide.slide-item :title="''" :currentBid="0" :imageUrl="''" :buttonAction="''"
                    :endDate="''" :searchResults="true" />
            </template>
        </div>
    </main>

    <script>
        let selectedCategories = [];
        document.querySelectorAll('[data-category]').forEach(button => {
            button.addEventListener('click', () => {
                const categoryId = button.getAttribute('data-category');

                // Toggle the selection
                if (selectedCategories.includes(categoryId)) {
                    selectedCategories = selectedCategories.filter(id => id !==
                        categoryId); // Remove if already selected
                    button.classList.remove('bg-gray-200', 'font-semibold'); // Reset style
                } else {
                    selectedCategories.push(categoryId); // Add to selected categories
                    button.classList.add('bg-gray-200', 'font-semibold'); // Apply "pressed" style
                }

                // Fetch results with the updated category disjunction
                fetchResults('auctions');
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
            const resultsContainer = document.getElementById('results-container');
            const errorMessage = document.getElementById('error-message');

            try {
                const searchTerm = '{{ $searchTerm }}';
                let url = `/api/${type}/search?search=${encodeURIComponent(searchTerm)}`;
                if (selectedCategories.length > 0) {
                    selectedCategories.forEach(id => {
                        url += `&category[]=${id}`;
                    });
                }

                const response = await fetch(url);

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Error:', errorData.error || 'Something went wrong');
                    errorMessage.style.display = 'flex';
                    errorMessage.querySelector('p').textContent = errorData.error || 'Failed to reach the server';
                    resultsContainer.style.display = 'none';
                    return;
                }

                const {
                    data,
                    message
                } = await response.json();

                if (!data || data.length === 0) {
                    errorMessage.style.display = 'flex';
                    errorMessage.querySelector('p').textContent = message || `No ${type} results found.`;
                    resultsContainer.style.display = 'none';
                    return;
                }

                // Hide error message and show results if we have data
                errorMessage.style.display = 'none';
                resultsContainer.style.display = 'grid';
                displayResults(data, type);

            } catch (error) {
                console.error('Unexpected error:', error);
                errorMessage.style.display = 'flex';
                errorMessage.querySelector('p').textContent = 'An unexpected error occurred.';
                resultsContainer.style.display = 'none';
            }
        }

        function displayResults(results, type) {
            const container = document.getElementById('results-container');
            const errorMessage = document.getElementById('error-message');
            container.innerHTML = '';

            if (!results.length) {
                errorMessage.style.display = 'flex';
                errorMessage.querySelector('p').textContent = `No ${type} results found.`;
                container.style.display = 'none';
                return;
            }

            errorMessage.style.display = 'none';
            container.style.display = 'grid';

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
                    const userDiv = document.createElement('div');
                    userDiv.innerHTML = `@include('search.user-card', [
                        'name' => '${item.name}',
                        'username' => '${item.username}',
                    ])`;
                    container.appendChild(userDiv.firstElementChild);
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

        .peer-checked+label {
            transition: background-color 0.3s ease-in-out, font-weight 0.3s ease-in-out;
        }
    </style>
@endsection
