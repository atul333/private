@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Campaign Payment</div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4>Payment Details</h4>
                        <p class="lead">Campaign Duration: {{ $campaign->duration }} Days</p>
                        <h2 class="mb-4">Amount: ${{ number_format($campaign->price, 2) }}</h2>
                        <div class="alert alert-info">
                            <h5>Wallet Balance</h5>
                            <h3>${{ number_format($wallet->balance ?? 0.00, 2) }}</h3>
                            @if($wallet->balance < $campaign->price)
                                <div class="alert alert-warning mt-2">
                                    <small>Insufficient balance. Please <a href="/{{ auth()->id() }}/advertiser/wallet">add funds</a> to your wallet.</small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center">
                        <form action="{{ route('campaigns.payment.process', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" method="GET">
                            <button type="submit" class="btn btn-primary btn-lg">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection