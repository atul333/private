@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Terms & Conditions</h1>
        
        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">1. Acceptance of Terms</h2>
                <p class="text-gray-600">By accessing and using SocialAdLinker's services, you agree to be bound by these terms and conditions. If you disagree with any part of these terms, you may not access our service.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">2. Description of Service</h2>
                <p class="text-gray-600">SocialAdLinker provides a platform for advertising on Telegram channels. We facilitate connections between advertisers and channel owners while maintaining quality standards and transparent pricing.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">3. User Accounts</h2>
                <p class="text-gray-600">Users must maintain accurate, complete, and up-to-date account information. Accounts are personal and may not be shared or transferred.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">4. Advertising Content</h2>
                <p class="text-gray-600">All advertising content must comply with our content guidelines. We reserve the right to reject or remove any content that violates these guidelines or applicable laws.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">5. Payment Terms</h2>
                <p class="text-gray-600">Payments are processed securely through our platform. Advertisers must maintain sufficient funds for their campaigns. Publishers will receive payments according to our payment schedule.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">6. Intellectual Property</h2>
                <p class="text-gray-600">Users retain their intellectual property rights. By using our platform, you grant us necessary licenses to display and process your content.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">7. Limitation of Liability</h2>
                <p class="text-gray-600">SocialAdLinker is not liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of our services.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">8. Changes to Terms</h2>
                <p class="text-gray-600">We reserve the right to modify these terms at any time. Users will be notified of significant changes.</p>
            </section>

            <section class="border-t pt-6">
                <p class="text-sm text-gray-500">Last updated: {{ date('F d, Y') }}</p>
            </section>
        </div>
    </div>
</div>
@endsection