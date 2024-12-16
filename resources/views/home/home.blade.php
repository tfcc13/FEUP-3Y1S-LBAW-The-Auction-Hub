@extends('layouts.app')

@section('content')
    <main class="flex flex-col items-center py-4 px-6 space-y-8 mb-16">
        <!-- Categories section -->
        <x-categories.categories :categories="$categories" />

        <!-- Carousel section -->
        <x-carousel.carousel :items="$carouselItems" />

        <div class="h-8"></div>

        <!-- Slide section -->
        <x-slide.slide :items="$slideItems" />

        <div class="h-8"></div>

        <!-- Brands section -->
        <x-brands.brands />
    </main>

    <!-- Footer section -->
    <x-footer.footer />
@endsection
