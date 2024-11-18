@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center px-4 py-8">
    <x-categories :categories="$categories" />
    <x-carousel :slides="$slides" />
</div>
@endsection