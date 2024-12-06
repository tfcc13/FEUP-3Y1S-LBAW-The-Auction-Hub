@extends('layouts.app')

@section('content')
    <main class="flex flex-col items-center py-4 px-6 space-y-8">
        <!-- Categories section -->
        <x-categories.categories :categories="$categories" />

        <!-- Carousel section -->
        <x-carousel.carousel :items="$carouselItems" />

        <div class="h-8"></div>

        <!-- Slide section -->
        <x-slide.slide :items="$slideItems" />
    </main>
@endsection
