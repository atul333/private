@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex flex-col h-full">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('publisher.wallet.index', ['id' => Auth::user()->id]) }}" class="flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="text-lg font-bold text-black">Withdraw Funds</h1>
            </div>
           
        </div>

        <!-- Content -->
        <div class="flex-1 p-6">
            <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden border border-[#4895EF]/30 hover:border-[#4361EE]/50">
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

                        <div class="p-6 space-y-6">
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
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Withdrawal Amount (₹)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" step="0.01" min="10" required
                                           class="block w-full pl-7 pr-12 py-2 rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE]"
                                           placeholder="0.00"
                                           oninput="calculateFees(this.value)">
                                </div>

                                <div id="feeDetails" class="mt-4 p-4 bg-blue-50 rounded-lg hidden">
                                    <div class="space-y-2 text-sm">
                                        <p>Withdrawal Amount: ₹<span id="withdrawalAmount">0.00</span></p>
                                        <p>Tax : ₹<span id="taxAmount">0.00</span></p>
                                        <p>Platform Fee : ₹<span id="platformFee">0.00</span></p>
                                        <p class="font-semibold text-base">You will receive: ₹<span id="finalAmount">0.00</span></p>
                                    </div>
                                </div>
                            </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" id="payment_upi" name="payment_method" value="upi" checked
                                           class="peer absolute opacity-0">
                                    <label for="payment_upi" 
                                           class="block w-full p-4 text-sm font-medium text-center rounded-lg border 
                                                  peer-checked:border-[#4361EE] peer-checked:bg-[#4361EE]/10 peer-checked:text-[#3A0CA3]
                                                  border-gray-300 text-gray-700 hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        UPI
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="payment_bank" name="payment_method" value="bank_transfer"
                                           class="peer absolute opacity-0">
                                    <label for="payment_bank" 
                                           class="block w-full p-4 text-sm font-medium text-center rounded-lg border 
                                                  peer-checked:border-[#4361EE] peer-checked:bg-[#4361EE]/10 peer-checked:text-[#3A0CA3]
                                                  border-gray-300 text-gray-700 hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                        </svg>
                                        Bank Transfer
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Fields --}}
                        <div class="mt-6 space-y-6">
                            {{-- UPI Fields --}}
                            <div id="upi_fields" class="space-y-4 hidden">
                                <div class="bg-white/50 p-4 rounded-lg border border-[#4361EE]/20">
                                    <div class="space-y-4">
                                        <div>
                                            <label for="first_name_upi" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                            <input type="text" name="first_name_upi" id="first_name_upi"
                                                   class="block w-full rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE] bg-white/90">
                                        </div>
                                        <div>
                                            <label for="upi_id" class="block text-sm font-medium text-gray-700 mb-2">UPI ID</label>
                                            <input type="text" name="upi_id" id="upi_id"
                                                   class="block w-full rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE] bg-white/90"
                                                   pattern="[a-zA-Z0-9._-]+@[a-zA-Z]{3,}"
                                                   title="Please enter a valid UPI ID (e.g., username@upi)"
                                                   placeholder="example@upi"
                                                   required>
                                            <p class="mt-1 text-sm text-gray-500">Format: username@upi (e.g., john@okaxis)</p>
                                        </div>
                                        <div>
                                            <label for="mobile_number_upi" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                                            <input type="tel" name="mobile_number_upi" id="mobile_number_upi"
                                                   class="block w-full rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE] bg-white/90"
                                                   pattern="[0-9]{10}" placeholder="Enter 10 digit mobile number">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Bank Fields --}}
                            <div id="bank_fields" class="space-y-4 hidden">
                                <div class="bg-white/50 p-4 rounded-lg border border-[#4361EE]/20">
                                    <div class="space-y-4">
                                        <div>
                                            <label for="account_holder_name" class="block text-sm font-medium text-gray-700 mb-2">Account Holder Name</label>
                                            <input type="text" name="account_holder_name" id="account_holder_name"
                                                   class="block w-full rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE] bg-white/90">
                                        </div>
                                        <div>
                                            <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">Account Number</label>
                                            <input type="text" name="account_number" id="account_number"
                                                   class="block w-full rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE] bg-white/90"
                                                   placeholder="Enter account number">
                                        </div>
                                        <div>
                                            <label for="ifsc_code" class="block text-sm font-medium text-gray-700 mb-2">IFSC Code</label>
                                            <input type="text" name="ifsc_code" id="ifsc_code"
                                                   class="block w-full rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE] bg-white/90"
                                                   placeholder="Enter IFSC code">
                                        </div>
                                        <div>
                                            <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">Bank Name</label>
                                            <input type="text" name="bank_name" id="bank_name"
                                                   class="block w-full rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE] bg-white/90"
                                                   placeholder="Enter bank name">
                                        </div>
                                        <div>
                                            <label for="mobile_number_bank" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                                            <input type="tel" name="mobile_number_bank" id="mobile_number_bank"
                                                   class="block w-full rounded-md border-gray-300 focus:ring-[#4361EE] focus:border-[#4361EE] bg-white/90"
                                                   pattern="[0-9]{10}" placeholder="Enter 10 digit mobile number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-6 px-6 pb-6">
                            <button type="submit" class="w-full bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] text-white font-semibold py-3 px-4 rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
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
    function calculateFees(amount) {
    const feeDetails = document.getElementById('feeDetails');
    if (amount >= 10) {
        const withdrawalAmount = parseFloat(amount);
        const taxRate = 0.03;
        const platformFeeRate = 0.07;
        
        const taxAmount = withdrawalAmount * taxRate;
        const platformFee = withdrawalAmount * platformFeeRate;
        const finalAmount = withdrawalAmount - taxAmount - platformFee;
        
        document.getElementById('withdrawalAmount').textContent = withdrawalAmount.toFixed(2);
        document.getElementById('taxAmount').textContent = taxAmount.toFixed(2);
        document.getElementById('platformFee').textContent = platformFee.toFixed(2);
        document.getElementById('finalAmount').textContent = finalAmount.toFixed(2);
        
        feeDetails.classList.remove('hidden');
    } else {
        feeDetails.classList.add('hidden');
    }
}

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
