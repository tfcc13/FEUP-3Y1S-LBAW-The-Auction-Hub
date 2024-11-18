@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center px-4 py-8">
    <x-categories :categories="$categories" />

    @php
    $slides = [
    [
    'title' => 'Product carousel',
    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    'buttonAction' => '',
    'imageUrl' => '/images/product1.jpg'
    ],
    [
    'title' => 'Second Slide',
    'description' => 'Another compelling product description goes here.',
    'buttonAction' => '',
    'imageUrl' => '/images/product2.jpg'
    ],
    // Add more slides as needed
    ];
    @endphp

    <x-carousel :slides="$slides" />
</div>
@endsection