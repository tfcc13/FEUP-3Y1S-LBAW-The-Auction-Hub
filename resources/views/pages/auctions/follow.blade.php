@extends('layouts.app')

@section('content')
@if ($followed->isNotEmpty())
@foreach ($followed as $auction)
<x-slide.slide-item
  :title="$auction->title"
  :currentBid="$auction->current_bid"
  :imageUrl="asset($auction->primaryImage())"
  :buttonAction="route('auctions.show', $auction->id)" />
@endforeach
@else
<p>You don't follow any auctions</p>
@endif
@endsection
