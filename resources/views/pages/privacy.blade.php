@extends('layouts.app')

@section('content')
    <main class="container mx-auto px-4 py-8 min-h-screen">
        <div class="max-w-4xl mx-auto space-y-6">
            <h1 class="text-3xl font-bold text-center mb-8">Privacy Policy</h1>
            
            <div class="space-y-4 text-justify leading-relaxed">
                <p>
                    At The Auction Hub, we take your privacy seriously. This policy outlines how we collect, use, and protect your personal information.
                </p>

                <h2 class="text-xl font-semibold mt-6">1. Information We Collect</h2>
                <p>
                    We collect information you provide directly to us, including but not limited to your name, email address,
                    billing address, and payment information. We also automatically collect certain information about your device
                    when you use our platform.
                </p>

                <h2 class="text-xl font-semibold mt-6">2. How We Use Your Information</h2>
                <p>
                    We use the information we collect to provide, maintain, and improve our services, to process your transactions,
                    communicate with you, and prevent fraud on our platform.
                </p>

                <h2 class="text-xl font-semibold mt-6">3. Information Sharing</h2>
                <p>
                    We do not sell your personal information to third parties. We may share your information with service providers
                    who assist in our operations and with law enforcement when required by law.
                </p>

                <h2 class="text-xl font-semibold mt-6">4. Data Security</h2>
                <p>
                    We implement appropriate technical and organizational measures to protect your personal information
                    against unauthorized access, alteration, disclosure, or destruction.
                </p>
            </div>
        </div>
    </main>

    @include('layouts.footer')
@endsection 