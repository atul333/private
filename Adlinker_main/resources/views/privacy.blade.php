@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Privacy Policy</h1>
        
        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">1. Information We Collect</h2>
                <p class="text-gray-600">We collect information that you provide directly to us, including:</p>
                <ul class="list-disc pl-6 mt-2 text-gray-600">
                    <li>Account information (name, email, phone number)</li>
                    <li>Payment information</li>
                    <li>Advertising preferences and history</li>
                    <li>Communication with our support team</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">2. How We Use Your Information</h2>
                <p class="text-gray-600">We use the collected information to:</p>
                <ul class="list-disc pl-6 mt-2 text-gray-600">
                    <li>Provide and improve our services</li>
                    <li>Process payments and transactions</li>
                    <li>Send important notifications</li>
                    <li>Analyze platform usage and trends</li>
                    <li>Prevent fraud and ensure platform security</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">3. Information Sharing</h2>
                <p class="text-gray-600">We do not sell your personal information. We may share your information with:</p>
                <ul class="list-disc pl-6 mt-2 text-gray-600">
                    <li>Service providers who assist in platform operations</li>
                    <li>Law enforcement when required by law</li>
                    <li>Other users as necessary for advertising services</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">4. Data Security</h2>
                <p class="text-gray-600">We implement appropriate security measures to protect your personal information from unauthorized access, alteration, or destruction.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">5. Your Rights</h2>
                <p class="text-gray-600">You have the right to:</p>
                <ul class="list-disc pl-6 mt-2 text-gray-600">
                    <li>Access your personal information</li>
                    <li>Correct inaccurate information</li>
                    <li>Request deletion of your information</li>
                    <li>Opt-out of marketing communications</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">6. Cookies and Tracking</h2>
                <p class="text-gray-600">We use cookies and similar technologies to improve user experience and analyze platform usage. You can control cookie settings through your browser preferences.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">7. Changes to Privacy Policy</h2>
                <p class="text-gray-600">We may update this privacy policy periodically. We will notify you of any significant changes through email or platform notifications.</p>
            </section>

            <section class="border-t pt-6">
                <p class="text-sm text-gray-500">Last updated: {{ date('F d, Y') }}</p>
                <p class="text-sm text-gray-500 mt-2">Contact us at socialadlinker@gmail.com for privacy-related questions.</p>
            </section>
        </div>
    </div>
</div>
@endsection