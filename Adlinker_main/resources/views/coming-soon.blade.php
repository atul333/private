@extends('layouts.app')

@section('title', ucfirst($platform) . ' - Coming Soon')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-8 text-center">
            <div class="mb-5">
                @if($platform === 'snapchat')
                    <i class="fab fa-snapchat" style="font-size: 8rem; color: #FFFC00;"></i>
                @elseif($platform === 'facebook')
                    <i class="fab fa-facebook" style="font-size: 8rem; color: #1877F2;"></i>
                @elseif($platform === 'youtube')
                    <i class="fab fa-youtube" style="font-size: 8rem; color: #FF0000;"></i>
                @endif
            </div>

            <h1 class="display-3 fw-bold mb-4">Coming Soon</h1>
            <p class="lead text-muted mb-5">
                {{ ucfirst($platform) }} integration will be available in the next phase of development.
                <br>Stay tuned for updates!
            </p>

            <div class="alert alert-info d-inline-block" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                This platform is currently under development and will be launched soon.
            </div>

            <div class="mt-5">
                <a href="{{ route('platform.selection') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Platform Selection
                </a>
            </div>

            <div class="mt-5 pt-5">
                <h5 class="text-muted mb-4">Currently Available Platforms:</h5>
                <div class="d-flex justify-content-center gap-4">
                    <div>
                        <i class="fab fa-telegram fa-3x" style="color: #0088cc;"></i>
                        <p class="mt-2 small">Telegram</p>
                    </div>
                    <div>
                        <i class="fab fa-instagram fa-3x" style="color: #E4405F;"></i>
                        <p class="mt-2 small">Instagram</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
