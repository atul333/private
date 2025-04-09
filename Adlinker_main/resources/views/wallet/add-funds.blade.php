@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                <h2 class="text-xl font-semibold text-white">Add Funds</h2>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="mb-4 p-4 rounded-md bg-green-50 border border-green-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 rounded-md bg-red-50 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form id="payment-form" class="space-y-6" onsubmit="return false;">
                    @csrf

                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <div class="mt-1">
                            <input id="fullName" type="text" name="fullName" value="{{ old('fullName') }}" required autofocus
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('fullName') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            @error('fullName')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mobileNumber" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                        <div class="mt-1">
                            <input id="mobileNumber" type="tel" name="mobileNumber" value="{{ old('mobileNumber') }}" required pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('mobileNumber') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Enter 10 digit mobile number">
                            @error('mobileNumber')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ old('amount') }}" required
                                class="appearance-none block w-full pl-7 pr-12 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('amount') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="0.00">
                            @error('amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <button type="button" id="rzp-button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Add Funds
                        </button>
                    </div>
                </form>

                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                <script>
                document.getElementById('rzp-button').addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const form = document.getElementById('payment-form');
                    const formData = new FormData(form);
                    
                    const usdAmount = parseFloat(document.getElementById('amount').value);
                    const inrAmount = Math.round(usdAmount * 85 * 100) / 100; // Convert USD to INR

                    fetch('{{ route("razorpay.create.order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            amount: inrAmount,
                            fullName: document.getElementById('fullName').value,
                            mobileNumber: document.getElementById('mobileNumber').value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const options = {
                            key: data.key,
                            amount: data.amount,
                            currency: data.currency,
                            order_id: data.order_id,
                            name: 'SocialAdLinker',
                            description: 'Add Funds to Wallet ($' + usdAmount.toFixed(2) + ' USD = ₹' + inrAmount.toFixed(2) + ' INR)',
                            handler: function(response) {
                                fetch('{{ route("razorpay.verify.payment") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_signature: response.razorpay_signature
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Payment verification failed');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        window.location.href = '{{ Auth::user()->role === "publisher" ? route("publisher.wallet.index") : "/" . Auth::user()->id . "/advertiser/wallet" }}';
                                    } else {
                                        throw new Error(data.message || 'Payment verification failed');
                                    }
                                })
                                .catch(error => {
                                    console.error('Payment verification error:', error);
                                    alert(error.message || 'An error occurred during payment verification. Please contact support if the issue persists.');
                                    window.location.reload();
                                });
                            },
                            prefill: {
                                name: document.getElementById('fullName').value,
                                contact: document.getElementById('mobileNumber').value
                            },
                            theme: {
                                color: '#2563EB'
                            }
                        };
                        const rzp = new Razorpay(options);
                        rzp.open();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to initialize payment');
                    });
                });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection