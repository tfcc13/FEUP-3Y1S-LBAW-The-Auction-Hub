@extends('layouts.app')

@section('content')
    <main class="flex flex-col items-center py-4 px-6 space-y-8">
        <!-- Categories Section -->
        <div id="categories-container" class="hidden w-full">
            <x-categories.categories :categories="$categories" />
        </div>
        <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">Search Results</h1>

        <!-- Toggle Buttons -->
        <div class="flex space-x-4 mb-6">
            <button id="toggle-auctions" class="toggle-btn px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                Auctions
            </button>
            <button id="toggle-users" class="toggle-btn px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-blue-700">
                Users
            </button>
        </div>

        <div class="toggle-button-cover">
            <div class="button-cover">
                <div class="button b2" id="button-10">
                    <input type="checkbox" class="checkbox" />
                    <div class="knobs">
                        <span>YES</span>
                    </div>
                    <div class="layer"></div>
                </div>
            </div>
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
        <div id="results-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>
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

                displayResults(type, data);

            } catch (error) {
                // Catch unexpected errors, such as network issues
                console.error('Unexpected error:', error);
                document.getElementById('results-container').innerHTML =
                    `<p class="text-red-500">An unexpected error occurred.</p>`;
            }
        }

        function displayResults(type, results) {
            const container = document.getElementById('results-container');
            container.innerHTML = '';

            if (!results.length) {
                container.innerHTML = `<p class="text-gray-600">No ${type} results found.</p>`;
                return;
            }

            results.forEach(item => {
                const card = type === 'auctions' ?
                    `<div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-3">${item.title}</h2>
<p class="text-gray-600 mb-4">${item.description.substring(0, 100)}...</p>          
<p class="text-gray-600 mb-4">Ending on: ${new Date(item.end_date).toLocaleString()}</p>
                        <a href="/auctions/auction/${item.id}" class="inline-block px-4 py-2 text-white sm:text-base rounded-md bg-[#135d3b] hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            View Auction
                        </a>
                    </div>
               </div>` :
                    `<div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-3">${item.name}</h2>
                        <p class="text-gray-600 mb-4">Username: ${item.username}</p>
                        <a href="/profile/${item.username}" class="inline-block px-4 py-2 text-white sm:text-base rounded-md bg-[#135d3b] hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            View Profile
                        </a>
                    </div>
               </div>`;
                container.innerHTML += card;
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
@endsection

<style>
    .toggle-button-cover {
        display: table-cell;
        position: relative;
        width: 200px;
        height: 140px;
        box-sizing: border-box;
    }

    .button-cover {
        height: 100px;
        margin: 20px;
        background-color: #fff;
        box-shadow: 0 10px 20px -8px #c5d6d6;
        border-radius: 4px;
    }

    .button-cover:before {
        counter-increment: button-counter;
        content: counter(button-counter);
        position: absolute;
        right: 0;
        bottom: 0;
        color: #d7e3e3;
        font-size: 12px;
        line-height: 1;
        padding: 5px;
    }

    .button-cover,
    .knobs,
    .layer {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .button {
        position: relative;
        top: 50%;
        width: 74px;
        height: 36px;
        margin: -20px auto 0 auto;
        overflow: hidden;
    }

    .button.r,
    .button.r .layer {
        border-radius: 100px;
    }

    .button.b2 {
        border-radius: 2px;
    }

    .checkbox {
        position: relative;
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 3;
    }

    .knobs {
        z-index: 2;
    }

    .layer {
        width: 100%;
        background-color: #ebf7fc;
        transition: 0.3s ease all;
        z-index: 1;
    }

    /* Button 10 */
    #button-10 .knobs:before,
    #button-10 .knobs:after,
    #button-10 .knobs span {
        position: absolute;
        top: 4px;
        width: 20px;
        height: 10px;
        font-size: 10px;
        font-weight: bold;
        text-align: center;
        line-height: 1;
        padding: 9px 4px;
        border-radius: 2px;
        transition: 0.3s ease all;
    }

    #button-10 .knobs:before {
        content: "";
        left: 4px;
        background-color: #03a9f4;
    }

    #button-10 .knobs:after {
        content: "NO";
        right: 4px;
        color: #4e4e4e;
    }

    #button-10 .knobs span {
        display: inline-block;
        left: 4px;
        color: #fff;
        z-index: 1;
    }

    #button-10 .checkbox:checked+.knobs span {
        color: #4e4e4e;
    }

    #button-10 .checkbox:checked+.knobs:before {
        left: 42px;
        background-color: #f44336;
    }

    #button-10 .checkbox:checked+.knobs:after {
        color: #fff;
    }

    #button-10 .checkbox:checked~.layer {
        background-color: #fcebeb;
    }
</style>
