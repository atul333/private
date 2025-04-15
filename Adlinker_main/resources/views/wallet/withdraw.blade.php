@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#CDB4DB] to-[#BDE0FE] py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 flex flex-col max-h-[90vh]">


                <!-- Header Section -->
                <div class="px-4 py-1.5 bg-gradient-to-r from-[#fb8500] to-[#ffb703] border-b border-[#CDB4DB]/20 flex justify-between items-center shrink-0">
                    <div class="flex items-center">
                        <a href="{{ route('publisher.wallet.index', ['id' => Auth::user()->id]) }}" class="flex items-center text-white/90 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Back</span>
                        </a>
                        <h1 class="ml-4 text-lg font-bold text-white">Withdraw Funds</h1>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-white/90">Available Balance</p>
                        <p class="text-xl font-bold text-white">${{ number_format($availableBalance, 2) }}</p>
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <form action="{{ route('publisher.wallet.process-withdrawal', ['id' => Auth::user()->id]) }}" method="POST">
                        @csrf

                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Withdrawal Amount ($)</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="amount" id="amount" step="0.01" min="1" required
                                       class="block w-full pl-7 pr-12 py-2 rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="0.00">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" id="payment_upi" name="payment_method" value="upi" checked
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="payment_upi" class="ml-2 block text-sm font-medium text-gray-700">UPI</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="payment_bank" name="payment_method" value="bank_transfer"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="payment_bank" class="ml-2 block text-sm font-medium text-gray-700">Bank Transfer</label>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Fields --}}
                        <div class="mt-6">
                            {{-- UPI Fields --}}
                            <div id="upi_fields" class="space-y-4 hidden">
                                <div>
                                    <label for="first_name_upi" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="first_name_upi" id="first_name_upi"
                                           class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="upi_id" class="block text-sm font-medium text-gray-700 mb-2">UPI ID</label>
                                    <input type="text" name="upi_id" id="upi_id"
                                           class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="example@upi">
                                </div>
                                <div>
                                    <label for="mobile_number_upi" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                                    <input type="tel" name="mobile_number_upi" id="mobile_number_upi"
                                           class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                           pattern="[0-9]{10}" placeholder="Enter 10 digit mobile number">
                                </div>
                            </div>

                            {{-- Bank Fields --}}
                            <div id="bank_fields" class="space-y-4 hidden">
                                <div>
                                    <label for="account_holder_name" class="block text-sm font-medium text-gray-700 mb-2">Account Holder Name</label>
                                    <input type="text" name="account_holder_name" id="account_holder_name"
                                           class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">Account Number</label>
                                    <input type="text" name="account_number" id="account_number"
                                           class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter account number">
                                </div>
                                <div>
                                    <label for="ifsc_code" class="block text-sm font-medium text-gray-700 mb-2">IFSC Code</label>
                                    <input type="text" name="ifsc_code" id="ifsc_code"
                                           class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter IFSC code">
                                </div>
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">Bank Name</label>
                                    <input type="text" name="bank_name" id="bank_name"
                                           class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter bank name">
                                </div>
                                <div>
                                    <label for="mobile_number_bank" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                                    <input type="tel" name="mobile_number_bank" id="mobile_number_bank"
                                           class="block w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                           pattern="[0-9]{10}" placeholder="Enter 10 digit mobile number">
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                Request Withdrawal
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const upiFields = document.getElementById('upi_fields');
        const bankFields = document.getElementById('bank_fields');
        const upiRadio = document.getElementById('payment_upi');
        const bankRadio = document.getElementById('payment_bank');

        // Show UPI fields by default
        upiFields.classList.remove('hidden');
        setFieldsRequired(upiFields, true);
        setFieldsRequired(bankFields, false);

        upiRadio.addEventListener('change', function () {
            if (this.checked) {
                upiFields.classList.remove('hidden');
                bankFields.classList.add('hidden');
                setFieldsRequired(upiFields, true);
                setFieldsRequired(bankFields, false);
            }
        });

        bankRadio.addEventListener('change', function () {
            if (this.checked) {
                bankFields.classList.remove('hidden');
                upiFields.classList.add('hidden');
                setFieldsRequired(bankFields, true);
                setFieldsRequired(upiFields, false);
            }
        });

        function setFieldsRequired(container, required) {
            const inputs = container.querySelectorAll('input');
            inputs.forEach(input => {
                input.required = required;
            });
        }
    });
</script>
@endsection
