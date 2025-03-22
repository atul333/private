@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Withdrawal') }}</span>
                    <a href="{{ route('publisher.withdrawals.index') }}" class="btn btn-secondary">Back to History</a>
                </div>

                <div class="card-body text-center">
                    <h2 class="display-4 mb-4">Withdraw Now</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection