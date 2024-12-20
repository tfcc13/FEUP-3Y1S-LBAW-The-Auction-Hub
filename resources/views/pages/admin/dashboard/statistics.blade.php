@extends('layouts.admin.dashboard')

@section('Display')

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="flex">
    <!-- Main Content Area -->
  <div class="flex-1 container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- User Statistics -->
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-medium mb-4">User Statistics</h3>
        <p class="text-lg">Active Users: <strong class="text-blue-600">{{ $activeUsers }}</strong></p>
        <p class="text-lg">Deleted Users: <strong class="text-red-600">{{ $deletedUsers }}</strong></p>
        <p class="text-lg">Total Users: <strong class="text-gray-600">{{ $totalUsers }}</strong></p>

        <!-- User State Chart -->
        <canvas id="userStateChart" class="mt-6 w-full h-48"></canvas>
      </div>

      <!-- Financial Statistics -->
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-medium mb-4">Financial Statistics</h3>
        <p class="text-lg">Total Transactions: <strong class="text-blue-600">{{ $transactionStats->total_transactions }}</strong></p>
        <p class="text-lg">Total Transaction Value: <strong class="text-green-600">${{ number_format($transactionStats->total_amount, 2) }}</strong></p>
        <p class="text-lg">Total Deposits: <strong class="text-green-600">${{ number_format($revenue->total_deposits, 2) }}</strong></p>
        <p class="text-lg">Total Withdrawals: <strong class="text-red-600">${{ number_format($revenue->total_withdrawals, 2) }}</strong></p>
        <p class="text-lg">Pending Withdrawals: <strong class="text-yellow-600">${{ number_format($pending->total_withdrawals, 2) }}</strong></p>

        <!-- Financial Stats Chart -->
        <canvas id="financialStatsChart" class="mt-6 w-full h-48"></canvas>
      </div>

      <!-- Top Bidders -->
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-medium mb-4">Top Bidders</h3>
        <ul class="space-y-2">
          @foreach ($topBidders as $bidder)
          <li class="text-lg">{{ $bidder->username }} ({{ $bidder->bid_count }} bids)</li>
          @endforeach
        </ul>

        <!-- Top Bidders Chart -->
        <canvas id="topBiddersChart" class="mt-6 w-full h-48"></canvas>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
      <!-- Popular Auctions -->
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-medium mb-4">Popular Auctions</h3>
        <ul class="space-y-2">
          @foreach ($popularAuctions as $auction)
          <li class="text-lg">{{ $auction->title }} ({{ $auction->bid_count }} bids)</li>
          @endforeach
        </ul>

        <!-- Popular Auctions Chart -->
        <canvas id="popularAuctionsChart" class="mt-6 w-full h-48"></canvas>
      </div>

      <!-- Sold Categories -->
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-medium mb-4">Sold Categories</h3>
        <ul class="space-y-2">
          @foreach ($topCategories as $category)
          <li class="text-lg">{{ $category->name }} ({{ $category->sold_count }} sold)</li>
          @endforeach
        </ul>

        <!-- Sold Categories Chart -->
        <canvas id="soldCategoriesChart" class="mt-6 w-full h-48"></canvas>
      </div>
    </div>

</div>

<script>
  // User State Chart
  var ctxUserState = document.getElementById('userStateChart').getContext('2d');
  var userStateChart = new Chart(ctxUserState, {
    type: 'pie',
    data: {
      labels: ['Active Users', 'Deleted Users'],
      datasets: [{
        data: [{{ $activeUsers }}, {{ $deletedUsers }}],
        backgroundColor: ['#36a2eb', '#ff6384'],
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          enabled: true,
        }
      }
    }
  });

  // Financial Stats Chart (Total Transactions & Value)
  var ctxFinancialStats = document.getElementById('financialStatsChart').getContext('2d');
  var financialStatsChart = new Chart(ctxFinancialStats, {
    type: 'bar',
    data: {
      labels: [ 'Total Transaction Value'],
      datasets: [{
        label: 'Financial Stats',
        data: [{{ $transactionStats->total_amount }}],
        backgroundColor: [ '#ff9f40'],
        borderColor: [ '#ff9f40'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          enabled: true,
        }
      }
    }
  });

  // Top Bidders Chart
  var ctxTopBidders = document.getElementById('topBiddersChart').getContext('2d');
  var topBiddersChart = new Chart(ctxTopBidders, {
    type: 'bar',
    data: {
      labels: @json($topBidders->pluck('username')),
      datasets: [{
        label: 'Bids',
        data: @json($topBidders->pluck('bid_count')),
        backgroundColor: '#36a2eb',
        borderColor: '#36a2eb',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          enabled: true,
        }
      }
    }
  });

  // Popular Auctions Chart
  var ctxPopularAuctions = document.getElementById('popularAuctionsChart').getContext('2d');
  var popularAuctionsChart = new Chart(ctxPopularAuctions, {
    type: 'bar',
    data: {
      labels: @json($popularAuctions->pluck('title')),
      datasets: [{
        label: 'Bid Count',
        data: @json($popularAuctions->pluck('bid_count')),
        backgroundColor: '#ff9f40',
        borderColor: '#ff9f40',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          enabled: true,
        }
      }
    }
  });

  // Sold Categories Chart
  var ctxSoldCategories = document.getElementById('soldCategoriesChart').getContext('2d');
  var soldCategoriesChart = new Chart(ctxSoldCategories, {
    type: 'pie',
    data: {
      labels: @json($topCategories->pluck('name')),
      datasets: [{
        data: @json($topCategories->pluck('sold_count')),
        backgroundColor: ['#36a2eb', '#ff6384', '#ffcd56', '#ff9f40', '#4bc0c0'],
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          enabled: true,
        }
      }
    }
  });
</script>

@endsection
