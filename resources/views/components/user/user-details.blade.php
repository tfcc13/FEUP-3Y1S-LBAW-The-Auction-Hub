@props(['name' => '', 'username', 'email', 'rating'])

<div class="flex flex-col w-full sm:w-80 space-y-4">
    @if ($name)
        <!-- Name -->
        <div class="flex items-baseline justify-between">
            <span class="text-gray-600 text-lg font-medium">Name: </span>
            <span class="text-gray-800 text-lg font-semibold">
                {{ $name }}
            </span>
        </div>
    @endif

    <!-- Username -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-lg font-medium">Username: </span>
        <span class="text-gray-800 text-lg font-semibold">
            {{ $username }}
        </span>
    </div>

    <!-- Email -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-lg font-medium">Email: </span>
        <span class="text-gray-800 text-lg font-semibold">
            {{ $email }}
        </span>
    </div>

    <!-- User Rating -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-lg font-medium">Rating: </span>
        <div class="flex items-center">
            @php
                $rating = $rating ?? 0;
                $fullStars = floor($rating);
                $hasHalfStar = $rating - $fullStars >= 0.5;
                $emptyStars = 5 - ceil($rating);
            @endphp

            @for ($i = 0; $i < $fullStars; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor"
                    viewBox="0 0 24 24" stroke="none">
                    <path
                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
            @endfor

            @if ($hasHalfStar)
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor"
                    viewBox="0 0 24 24" stroke="none">
                    <path
                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
            @endif

            @for ($i = 0; $i < $emptyStars; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path
                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
            @endfor
        </div>
    </div>
</div>
