@extends('layouts.app')

@section('content')
    <main class="flex flex-row w-full min-h-screen">
        <aside id="categories-container"
            class="bg-gray-100 min-h-full p-4 space-y-6 transition-all duration-300 sticky top-0">
            <div class="flex items-center space-x-4">
                <button id="collapse-filter"
                    class="flex p-2 font-semibold text-gray-600 hover:bg-gray-200 rounded-full items-center 
                    justify-center transition-all active:scale-95"
                    aria-label="Toggle filters">
                    <span class="material-symbols-outlined select-none transition-transform duration-300">menu</span>
                </button>
                <h2 class="text-lg font-semibold text-gray-800">Filters</h2>
            </div>
            <nav aria-label="Product Categories" class="space-y-2" role="list">
                @foreach ($categories as $category)
                    <div id="{{ $category->id }}" class="flex items-start justify-between" role="listitem">
                        <button
                            class="w-full text-left p-2 rounded-2xl bg-transparent hover:bg-gray-200 flex items-center justify-between"
                            aria-label="{{ $category->name }}" title="{{ $category->name }}" id="{{ $category->id }}"
                            data-category="{{ $category->id }}">
                            <span>{{ $category->name }}</span>
                            <span class="material-symbols-outlined text-white bg-[#135d3b] rounded-full hidden check-icon"
                                style="font-size: 1.2rem;">done</span>
                        </button>
                    </div>
                @endforeach
            </nav>
        </aside>

        <div class="flex-1 flex flex-col items-center py-4 sm:px-6 space-y-8 overflow-y-auto">

            <!-- Header Section -->
            <div
                class="flex flex-col md:flex-row items-center justify-center w-full space-y-2 space-x-0 md:space-y-0 md:space-x-6">
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 text-center whitespace-nowrap">Search Results
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
                <p class="text-center"></p>
            </div>

            <!-- Results Container -->
            <div id="results-container" class="grid gap-8 transition-all duration-300"
                style="grid-template-columns: repeat(1, minmax(0, 1fr));">
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
        const categoriesContainer = document.getElementById('categories-container');
        const collapseButton = document.getElementById('collapse-filter');
        const menuIcon = collapseButton.querySelector('.material-symbols-outlined');
        let isCollapsed = window.innerWidth < 768;
        const resultsContainer = document.getElementById('results-container');

        function updateGridColumns() {
            const width = window.innerWidth;
            let columns;

            if (width < 768) { // md
                columns = 1;
            } else if (width < 1024) { // lg
                columns = isCollapsed ? 2 : 1;
            } else if (width < 1280) { // xl
                columns = isCollapsed ? 3 : 2;
            } else { // 2xl and up
                columns = isCollapsed ? 4 : 3;
            }

            resultsContainer.style.gridTemplateColumns = `repeat(${columns}, minmax(0, 1fr))`;
        }

        // Function to toggle sidebar
        function toggleSidebar() {
            isCollapsed = !isCollapsed;
            updateSidebarState();
            updateGridColumns();
        }

        // Function to update sidebar state
        function updateSidebarState() {
            if (isCollapsed) {
                // Collapse sidebar
                categoriesContainer.classList.remove('w-64', 'p-4');
                categoriesContainer.classList.add('px-2', 'py-4');
                menuIcon.style.transform = 'rotate(180deg)';

                // Hide elements
                categoriesContainer.querySelectorAll('h2, nav').forEach(el => el.classList.add('hidden'));
            } else {
                // Expand sidebar
                categoriesContainer.classList.remove('px-2', 'py-4');
                categoriesContainer.classList.add('w-64', 'p-4');
                menuIcon.style.transform = 'rotate(0deg)';

                // Show elements
                categoriesContainer.querySelectorAll('h2, nav').forEach(el => el.classList.remove('hidden'));
            }
        }

        // Initial setup
        document.addEventListener('DOMContentLoaded', () => {
            updateSidebarState();
            updateGridColumns();
            fetchResults('auctions');
        });

        // Toggle sidebar when collapse button is clicked
        collapseButton.addEventListener('click', toggleSidebar);

        // Handle window resize
        window.addEventListener('resize', () => {
            const shouldBeCollapsed = window.innerWidth < 1024;
            if (shouldBeCollapsed !== isCollapsed) {
                isCollapsed = shouldBeCollapsed;
                updateSidebarState();
            }
            updateGridColumns();
        });

        document.querySelectorAll('[data-category]').forEach(button => {
            button.addEventListener('click', () => {
                const categoryId = button.getAttribute('data-category');
                const checkIcon = button.querySelector('.check-icon');

                // Toggle the selection
                if (selectedCategories.includes(categoryId)) {
                    selectedCategories = selectedCategories.filter(id => id !== categoryId);
                    button.classList.remove('bg-gray-200', 'font-semibold');
                    checkIcon.classList.add('hidden');
                } else {
                    selectedCategories.push(categoryId);
                    button.classList.add('bg-gray-200', 'font-semibold');
                    checkIcon.classList.remove('hidden');
                }

                // Fetch results with the updated category disjunction
                fetchResults('auctions');
            });
        });
        document.getElementById('toggle-auctions').addEventListener('click', () => {
            setActiveButton('toggle-auctions');

            resultsContainer.classList.remove('hidden'); // Show categories
            fetchResults('auctions');
        });

        document.getElementById('toggle-users').addEventListener('click', () => {
            setActiveButton('toggle-users');
            resultsContainer.classList.add('hidden'); // Hide categories
            fetchResults('users');
        });

        async function fetchResults(type, categoryId = '') {
            try {
                const searchTerm = '{{ $searchTerm }}';
                let url = `/api/${type}/search?search=${encodeURIComponent(searchTerm)}`;
                if (selectedCategories.length > 0) {
                    selectedCategories.forEach(id => {
                        url += `&category[]=${id}`;
                    });
                }

                const response = await fetch(url);

                console.log(url);
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
                if (type === 'auctions') {
                    const now = new Date();
                    const validData = data.filter(auction => {
                        const endDate = new Date(auction.end_date);
                        return endDate > now; // Only keep auctions that haven't ended
                    });

                    if (validData.length === 0) {
                        document.getElementById('results-container').innerHTML =
                            `<p class="text-gray-600">${message || `No ${type} results found.`}</p>`;
                        return;
                    }
                    displayResults(validData, type);
                } else {
                    console.log("yuio");
                    displayResults(data, type);
                }

            } catch (error) {
                // Catch unexpected errors, such as network issues
                console.error('Unexpected error:', error);
                document.getElementById('results-container').innerHTML =
                    `<p class="text-red-500">An unexpected error occurred.</p>`;
            }
        }

        function displayResults(results, type) {
            const errorMessage = document.getElementById('error-message');
            resultsContainer.innerHTML = '';

            if (!results.length) {
                errorMessage.style.display = 'flex';
                errorMessage.querySelector('p').textContent = `No ${type} results found.`;
                resultsContainer.style.display = 'none';
                return;
            }

            errorMessage.style.display = 'none';
            resultsContainer.style.display = 'grid';

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

                    resultsContainer.appendChild(clone);
                } else {
                    const userDiv = document.createElement('div');
                    userDiv.innerHTML = `@include('search.user-card', [
                        'name' => '${item.name}',
                        'username' => '${item.username}',
                    ])`;
                    resultsContainer.appendChild(userDiv.firstElementChild);
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
