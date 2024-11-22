@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center px-4 py-8 space-y-8">
        <!-- Categories section -->
        <x-categories.categories :categories="$categories" />

        <!-- Carousel section -->
        <x-carousel.carousel :items="$carouselItems" />

        <div class="h-12"></div>

        <!-- Slide section -->
        <x-slide.slide>
            @foreach ($slideItems as $item)
                <x-slide.slide-item :title="$item['title']" :currentBid="$item['current_bid']" :imageUrl="$item['imageUrl']" :buttonAction="$item['buttonAction']" />
            @endforeach
        </x-slide.slide>
    </div>
@endsection
