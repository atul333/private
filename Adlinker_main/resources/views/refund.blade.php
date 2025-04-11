@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Refund Policy</h1>
        
        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Refund Timeline</h2>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <p class="text-blue-700">SocialAdLinker offers a <strong>7-day refund window</strong> for unused advertising credits.</p>
                </div>
                <p class="text-gray-600">Our refund policy is designed to provide flexibility while maintaining fair usage of our platform.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Eligible for Refund</h2>
                <ul class="list-disc pl-6 text-gray-600 space-y-2">
                    <li>Unused advertising credits within 7 days of purchase</li>
                    <li>Technical issues preventing campaign delivery</li>
                    <li>Service unavailability affecting campaign performance</li>
                    <li>Duplicate or erroneous charges</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Not Eligible for Refund</h2>
                <ul class="list-disc pl-6 text-gray-600 space-y-2">
                    <li>Used or partially used advertising credits</li>
                    <li>Requests made after the 7-day window</li>
                    <li>Campaign performance issues not related to technical problems</li>
                    <li>Violations of our terms of service</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Refund Process</h2>
                <ol class="list-decimal pl-6 text-gray-600 space-y-2">
                    <li>Submit a refund request through your dashboard or contact support</li>
                    <li>Provide the reason for your refund request</li>
                    <li>Our team will review your request within 48 hours</li>
                    <li>If approved, refunds will be processed to the original payment method</li>
                    <li>Refund processing may take 5-10 business days depending on your payment provider</li>
                </ol>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Special Circumstances</h2>
                <p class="text-gray-600">We may consider refund requests outside the standard policy in exceptional circumstances. These will be evaluated on a case-by-case basis.</p>
            </section>

            <section class="bg-gray-50 p-4 rounded-lg mt-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Need Help?</h2>
                <p class="text-gray-600">Contact our support team for assistance with refunds:</p>
                <ul class="mt-2 text-gray-600">
                    <li><i class="fas fa-envelope mr-2"></i>socialadlinker@gmail.com</li>
                    <li><i class="fas fa-phone mr-2"></i>+91 8329707239</li>
                </ul>
            </section>

            <section class="border-t pt-6">
                <p class="text-sm text-gray-500">Last updated: {{ date('F d, Y') }}</p>
            </section>
        </div>
    </div>
</div>
@endsection