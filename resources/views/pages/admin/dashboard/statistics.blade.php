@extends('layouts.admin.dashboard')

@section('Display')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex flex-col space-y-6 w-full" id="admin-auctions">
        <h3 class="text-2xl font-semibold text-gray-800">Manage Statistics</h3>

        <!-- Grid Container for Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Chart 1 -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <div style="position: relative; width: 100%; height: auto; max-width: 600px; margin: 0 auto;">
                    <x-chartjs-component :chart="$usersDoughnut" />
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4">
                <div style="position: relative; width: 100%; height: auto; max-width: 600px; margin: 0 auto;">
                    <x-chartjs-component :chart="$activeUsersLineChart" />
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <div style="position: relative; width: 100%; height: auto; max-width: 600px; margin: 0 auto;">
                    <x-chartjs-component :chart="$demographicsChart" />
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <div style="position: relative; width: 100%; height: auto; max-width: 600px; margin: 0 auto;">

                    <x-chartjs-component :chart="$auctionsDoughnut" />
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <div style="position: relative; width: 100%; height: auto; max-width: 600px; margin: 0 auto;">
                    <x-chartjs-component :chart="$bidsByMonth" />

                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <div style="position: relative; width: 100%; height: auto; max-width: 600px; margin: 0 auto;">
                    <x-chartjs-component :chart="$categoryBidsChart" />

                </div>
            </div>

        </div>
    </div>
@endsection
