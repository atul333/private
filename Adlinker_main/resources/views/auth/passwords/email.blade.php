@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl">
                <div class="px-4 py-3 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20">
                    <h2 class="text-xl font-bold text-white text-center">{{ __('Reset Password') }}</h2>
                    <p class="mt-1 text-center text-sm text-white/90">{{ __('Reset your password') }}</p>
                </div>
                <div class="p-6 space-y-4">
                    @if (session('status'))
                        <div class="mb-4 text-sm text-[#4CC9F0] bg-[#4CC9F0]/10 rounded-md p-4 border border-[#4CC9F0]/30" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                                <div class="mt-1">
                                    <input id="email" type="email" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#F72585] focus:border-[#F72585] sm:text-sm @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div class="mt-6">
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-[#F72585] to-[#B5179E] hover:from-[#B5179E] hover:to-[#F72585] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F72585]">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
