@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Cancellation Policy</h1>
        
        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Campaign Cancellation</h2>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                    <p class="text-yellow-700">Active campaigns can be canceled at any time through your dashboard. Unused credits will be returned to your account balance.</p>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Cancellation Process</h2>
                <ol class="list-decimal pl-6 text-gray-600 space-y-2">
                    <li>Log into your AdLinker dashboard</li>
                    <li>Navigate to the active campaigns section</li>
                    <li>Select the campaign you wish to cancel</li>
                    <li>Click the "Cancel Campaign" button</li>
                    <li>Confirm your cancellation</li>
                </ol>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Effects of Cancellation</h2>
                <ul class="list-disc pl-6 text-gray-600 space-y-2">
                    <li>Campaign will stop immediately upon cancellation</li>
                    <li>Unused advertising credits will be returned to your account</li>
                    <li>Campaign statistics will remain available in your dashboard</li>
                    <li>Scheduled posts that haven't been published will be canceled</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Account Cancellation</h2>
                <p class="text-gray-600 mb-4">To cancel your AdLinker account:</p>
                <ol class="list-decimal pl-6 text-gray-600 space-y-2">
                    <li>Ensure all active campaigns are completed or canceled</li>
                    <li>Withdraw any remaining balance from your account</li>
                    <li>Contact support to request account deletion</li>
                    <li>Confirm account deletion via email</li>
                </ol>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Publisher Cancellation Terms</h2>
                <ul class="list-disc pl-6 text-gray-600 space-y-2">
                    <li>Publishers must provide 30 days notice before removing channels</li>
                    <li>All pending payments will be processed before account closure</li>
                    <li>Channel statistics and performance data will be archived</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Automatic Cancellations</h2>
                <p class="text-gray-600">Campaigns may be automatically canceled in the following cases:</p>
                <ul class="list-disc pl-6 text-gray-600 space-y-2">
                    <li>Violation of our terms of service</li>
                    <li>Insufficient funds in account</li>
                    <li>Extended period of account inactivity</li>
                    <li>Platform maintenance or technical issues</li>
                </ul>
            </section>

            <section class="bg-gray-50 p-4 rounded-lg mt-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Need Assistance?</h2>
                <p class="text-gray-600">Our support team is available to help with cancellations:</p>
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