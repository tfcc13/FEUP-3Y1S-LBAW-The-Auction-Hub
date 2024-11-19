@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center px-4 py-8">
    <x-categories.categories :categories="$categories" />
    <x-carousel.carousel :items="$carouselItems" />
</div>
@endsection