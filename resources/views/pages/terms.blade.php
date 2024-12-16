@extends('layouts.app')

@section('content')
    <main class="container mx-auto px-4 py-8 min-h-screen">
        <div class="max-w-4xl mx-auto space-y-6">
            <h1 class="text-3xl font-bold text-center mb-8">Terms of Service</h1>
            
            <div class="space-y-4 text-justify leading-relaxed">
                <p>
                    Welcome to The Auction Hub. By accessing and using our platform, you agree to comply with and be bound by the following terms and conditions.
                </p>

                <h2 class="text-xl font-semibold mt-6">1. Acceptance of Terms</h2>
                <p>
                    By accessing and using The Auction Hub, you acknowledge that you have read, understood, and agree to be bound by these terms of service.
                    These terms may be updated from time to time without notice.
                </p>

                <h2 class="text-xl font-semibold mt-6">2. User Responsibilities</h2>
                <p>
                    Users must provide accurate information when registering and participating in auctions.
                    Any fraudulent activity or misrepresentation will result in immediate account termination.
                </p>

                <h2 class="text-xl font-semibold mt-6">3. Auction Rules</h2>
                <p>
                    All bids are binding and subject to the following conditions:
                </p>
                <ul class="list-disc pl-6 space-y-2 mt-2">
                    <li>
                        Users must maintain sufficient funds in their platform account to cover their bids.
                    </li>
                    <li>
                        When placing a bid, the corresponding amount will be held from the user's account balance.
                        This ensures that all bids are backed by real funds.
                    </li>
                    <li>
                        If a higher bid is placed, the previous bidder's held funds will be automatically released
                        back to their account balance.
                    </li>
                    <li>
                        The winning bidder's held funds will be automatically processed for payment when the auction ends.
                    </li>
                    <li>
                        Users cannot withdraw held funds while they are the highest bidder in an active auction.
                    </li>
                    <li>
                        Bids cannot be retracted once placed. Users should carefully consider their bids before submitting.
                    </li>
                    <li>
                        The Auction Hub reserves the right to cancel any auction or bid at its discretion, particularly
                        in cases of suspected fraudulent activity or system malfunction.
                    </li>
                </ul>

                <h2 class="text-xl font-semibold mt-6">4. Platform Currency and Transactions</h2>
                <p>
                    Users can deposit and withdraw money from their platform account subject to our financial policies.
                    All transactions and bids on the platform are final. The platform maintains strict security measures
                    to protect users' financial information and transactions.
                </p>

                <h2 class="text-xl font-semibold mt-6">5. Liability</h2>
                <p>
                    The Auction Hub is not liable for any damages or losses incurred through the use of our platform.
                    Users participate in auctions at their own risk. However, we implement robust security measures
                    to protect transactions and user funds within the platform.
                </p>
            </div>
        </div>
    </main>

    @include('layouts.footer')
@endsection 