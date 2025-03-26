@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Campaign Payment</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4>Total Amount: ${{ number_format($campaign->price, 2) }}</h4>
                        <p class="text-muted">Campaign Duration: {{ $campaign->duration }} days</p>
                        <p class="text-muted">Channel: {{ $campaign->channel_name }}</p>
                    </div>

                    <div class="text-center">
                        <button id="rzp-button" class="btn btn-primary btn-lg">Pay Now</button>
                    </div>

                    <form id="payment-form" action="{{ route('campaigns.payment.complete', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('rzp-button');
    if (!payButton) {
        console.error('Payment button not found');
        return;
    }

    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        const options = {
            "key": "{{ config('services.razorpay.key') }}",
            "amount": "{{ $campaign->price * 100 }}",
            "currency": "USD",
            "name": "{{ config('app.name') }}",
            "description": "Campaign Payment for {{ $campaign->channel_name }}",
            "order_id": "{{ $orderId }}",
            "handler": function (response) {
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                document.getElementById('payment-form').submit();
            },
            "prefill": {
                "name": "{{ auth()->user()->name }}",
                "email": "{{ auth()->user()->email }}"
            },
            "theme": {
                "color": "#0d6efd"
            },
            "modal": {
                "ondismiss": function() {
                    console.log('Checkout form closed');
                }
            }
        };

        try {
            const rzp = new Razorpay(options);
            rzp.open();
        } catch (error) {
            console.error('Failed to initialize Razorpay:', error);
            alert('Payment initialization failed. Please try again.');
        }
    });
});
</script>
@endpush
@endsection