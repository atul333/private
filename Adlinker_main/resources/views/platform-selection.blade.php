@extends('layouts.app')

@section('title', 'Select Platform')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">Choose Your Platform</h1>
                <p class="lead text-muted">Select a platform to manage your campaigns</p>
            </div>

            <div class="row g-4">
                <!-- Telegram Platform -->
                <div class="col-md-6">
                    <form action="{{ route('platform.select') }}" method="POST">
                        @csrf
                        <input type="hidden" name="platform" value="telegram">
                        <button type="submit" class="platform-card w-100 border-0 p-0">
                            <div class="card h-100 shadow-sm hover-lift">
                                <div class="card-body text-center p-5">
                                    <div class="platform-icon mb-4" style="font-size: 4rem;">
                                        <i class="fab fa-telegram" style="color: #0088cc;"></i>
                                    </div>
                                    <h3 class="card-title mb-3">Telegram</h3>
                                    <p class="card-text text-muted">Manage Telegram channel advertisements</p>
                                    <span class="badge bg-success mt-3">Active</span>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Instagram Platform -->
                <div class="col-md-6">
                    <form action="{{ route('platform.select') }}" method="POST">
                        @csrf
                        <input type="hidden" name="platform" value="instagram">
                        <button type="submit" class="platform-card w-100 border-0 p-0">
                            <div class="card h-100 shadow-sm hover-lift">
                                <div class="card-body text-center p-5">
                                    <div class="platform-icon mb-4" style="font-size: 4rem;">
                                        <i class="fab fa-instagram" style="color: #E4405F;"></i>
                                    </div>
                                    <h3 class="card-title mb-3">Instagram</h3>
                                    <p class="card-text text-muted">Manage Instagram story advertisements</p>
                                    <span class="badge bg-success mt-3">Active</span>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Snapchat Platform -->
                <div class="col-md-6">
                    <form action="{{ route('platform.select') }}" method="POST">
                        @csrf
                        <input type="hidden" name="platform" value="snapchat">
                        <button type="submit" class="platform-card w-100 border-0 p-0">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center p-5 opacity-75">
                                    <div class="platform-icon mb-4" style="font-size: 4rem;">
                                        <i class="fab fa-snapchat" style="color: #FFFC00;"></i>
                                    </div>
                                    <h3 class="card-title mb-3">Snapchat</h3>
                                    <p class="card-text text-muted">Manage Snapchat advertisements</p>
                                    <span class="badge bg-warning text-dark mt-3">Coming Soon</span>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Facebook Platform -->
                <div class="col-md-6">
                    <form action="{{ route('platform.select') }}" method="POST">
                        @csrf
                        <input type="hidden" name="platform" value="facebook">
                        <button type="submit" class="platform-card w-100 border-0 p-0">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center p-5 opacity-75">
                                    <div class="platform-icon mb-4" style="font-size: 4rem;">
                                        <i class="fab fa-facebook" style="color: #1877F2;"></i>
                                    </div>
                                    <h3 class="card-title mb-3">Facebook</h3>
                                    <p class="card-text text-muted">Manage Facebook advertisements</p>
                                    <span class="badge bg-warning text-dark mt-3">Coming Soon</span>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- YouTube Platform -->
                <div class="col-md-6">
                    <form action="{{ route('platform.select') }}" method="POST">
                        @csrf
                        <input type="hidden" name="platform" value="youtube">
                        <button type="submit" class="platform-card w-100 border-0 p-0">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center p-5 opacity-75">
                                    <div class="platform-icon mb-4" style="font-size: 4rem;">
                                        <i class="fab fa-youtube" style="color: #FF0000;"></i>
                                    </div>
                                    <h3 class="card-title mb-3">YouTube</h3>
                                    <p class="card-text text-muted">Manage YouTube advertisements</p>
                                    <span class="badge bg-warning text-dark mt-3">Coming Soon</span>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .platform-card {
        background: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .platform-card:hover .hover-lift {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .platform-card:focus {
        outline: none;
    }
</style>
@endsection
