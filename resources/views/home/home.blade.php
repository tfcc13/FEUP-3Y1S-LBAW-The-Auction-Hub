@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center px-8">
    <x-categories :categories="$categories" />
</div>
@endsection