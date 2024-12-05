@extends('layouts.user')

@section('content')
@if ($bidsMade->isEmpty())
<div class="alert alert-info text-center">
  <p>No bids found.</p>
</div>
@else
<div class="row">
  @foreach ($bidsMade as $bid)
  <div class="col-md-6 mb-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Bid ID: {{ $bid->id }}</h5>
        <p class="card-text">
          <strong>Amount:</strong> ${{ number_format($bid->amount, 2) }}
        </p>
        <p class="card-text">
          <strong>Auction:</strong> {{ $bid->auction->title }}
        </p>
        <button
          onclick="window.location.href='{{ route('auctions.show', $bid->auction->id) }}'"
          class="btn btn-primary w-100">
          View Auction
        </button>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endif
@endsection
