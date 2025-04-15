@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#fb8500] to-[#ffb703] border-b border-[#7209B7]/20 flex justify-between items-center shrink-0">
            <div class="flex items-center">
                <a href="{{ Auth::user()->role === 'publisher' ? route('publisher.wallet.index') : '/' . Auth::user()->id . '/advertiser/wallet' }}" class="flex items-center text-white/90 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back</span>
                </a>
                <h1 class="ml-4 text-xl font-bold text-white">Add Funds</h1>
            </div>
        </div>

         <!-- Scrollable Content Section -->
         <div class="flex-1 overflow-y-auto px-4 py-4 min-h-0">
             <div class="max-w-md mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                 <div class="p-6">
                     @if (session('success'))
                     <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                         <strong class="font-bold">Success!</strong>
                         <span class="block sm:inline">{{ session('success') }}</span>
                     </div>
                     @endif

                     @if (session('error'))
                     <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                         <strong class="font-bold">Error!</strong>
                         <span class="block sm:inline">{{ session('error') }}</span>
                     </div>
                     @endif

                <form id="payment-form" class="space-y-6" onsubmit="return validateForm();">
                    @csrf

                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input id="fullName" type="text" name="fullName" value="{{ old('fullName') }}" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('fullName') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="Enter your full name">
                            <p id="fullNameError" class="mt-2 text-sm text-red-600 hidden">Full name is required</p>
                            @error('fullName')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mobileNumber" class="block text-sm font-medium text-gray-700">Mobile Number <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input id="mobileNumber" type="tel" name="mobileNumber" value="{{ old('mobileNumber') }}" required pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('mobileNumber') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Enter 10 digit mobile number">
                            <p id="mobileNumberError" class="mt-2 text-sm text-red-600 hidden">Please enter a valid 10-digit mobile number</p>
                            @error('mobileNumber')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount (USD) <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" step="0.01" min="1" value="{{ old('amount') }}" required
                                class="appearance-none block w-full pl-7 pr-12 py-2 border border-[#4895EF]/30 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] transition-all duration-200 sm:text-sm @error('amount') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">USD</span>
                            </div>
                            <p id="amountError" class="mt-2 text-sm text-red-600 hidden">Please enter a valid amount</p>
                            @error('amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-between space-x-4 mb-4">
                        <button type="button" onclick="document.getElementById('amount').value='100'" class="inline-flex items-center px-4 py-2 border border-[#4895EF]/30 shadow-sm text-sm font-medium rounded-lg text-[#3A0CA3] bg-[#4361EE]/10 hover:bg-[#4361EE]/20 transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                            $100
                        </button>
                        <button type="button" onclick="document.getElementById('amount').value='500'" class="inline-flex items-center px-4 py-2 border border-[#4895EF]/30 shadow-sm text-sm font-medium rounded-lg text-[#3A0CA3] bg-[#4361EE]/10 hover:bg-[#4361EE]/20 transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                            $500
                        </button>
                        <button type="button" onclick="document.getElementById('amount').value='1000'" class="inline-flex items-center px-4 py-2 border border-[#4895EF]/30 shadow-sm text-sm font-medium rounded-lg text-[#3A0CA3] bg-[#4361EE]/10 hover:bg-[#4361EE]/20 transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                            $1000
                        </button>
                    </div>
                    <div>
                        <button type="button" id="rzp-button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                            Add Funds
                        </button>
                    </div>
                </form>

                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                <script>
                function validateForm() {
                    let isValid = true;
                    const fullName = document.getElementById('fullName');
                    const mobileNumber = document.getElementById('mobileNumber');
                    const amount = document.getElementById('amount');
                    const fullNameError = document.getElementById('fullNameError');
                    const mobileNumberError = document.getElementById('mobileNumberError');
                    const amountError = document.getElementById('amountError');

                    // Reset error messages
                    fullNameError.classList.add('hidden');
                    mobileNumberError.classList.add('hidden');
                    amountError.classList.add('hidden');

                    // Validate Full Name
                    if (!fullName.value.trim()) {
                        fullNameError.classList.remove('hidden');
                        isValid = false;
                    }

                    // Validate Mobile Number
                    if (!mobileNumber.value.trim() || !/^[0-9]{10}$/.test(mobileNumber.value)) {
                        mobileNumberError.classList.remove('hidden');
                        isValid = false;
                    }

                    // Validate Amount
                    if (!amount.value || parseFloat(amount.value) <= 0) {
                        amountError.classList.remove('hidden');
                        isValid = false;
                    }

                    return isValid;
                }

                document.getElementById('rzp-button').addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!validateForm()) return;
                    
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
                                        razorpay_signature: response.razorpay_signature,
                                        fullName: document.getElementById('fullName').value,
                                        mobileNumber: document.getElementById('mobileNumber').value
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.href = '{{ Auth::user()->role === "publisher" ? route("publisher.wallet.index") : "/" . Auth::user()->id . "/advertiser/wallet" }}';
                                    } else {
                                        // Remove any existing error messages
                                        const existingErrors = document.querySelectorAll('.error-message');
                                        existingErrors.forEach(error => error.remove());
                                        
                                        // Create new error message
                                        const errorDiv = document.createElement('div');
                                        errorDiv.className = 'mb-4 p-4 rounded-md bg-red-50 border border-red-200 error-message';
                                        errorDiv.innerHTML = `
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-red-800">${data.error || data.message || 'Payment verification failed. Please try again or contact support.'}</p>
                                                </div>
                                            </div>
                                        `;
                                        const form = document.getElementById('payment-form');
                                        form.insertBefore(errorDiv, form.firstChild);
                                        
                                        // Reset the form state
                                        document.getElementById('rzp-button').disabled = false;
                                    }
                                })
                                .catch(error => {
                                    console.error('Payment verification error:', error);
                                    // Display error in the UI
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'mb-4 p-4 rounded-md bg-red-50 border border-red-200';
                                    errorDiv.innerHTML = `
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-red-800">An error occurred during payment verification. Please try again or contact support.</p>
                                            </div>
                                        </div>
                                    `;
                                    const form = document.getElementById('payment-form');
                                    form.insertBefore(errorDiv, form.firstChild);
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