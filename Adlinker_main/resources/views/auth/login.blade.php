@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl">
                <div class="px-4 py-1.5 bg-gradient-to-r from-[#fb8500] to-[#ffb703] border-b border-[#7209B7]/20">
                    <h2 class="text-xl font-bold text-white text-center">{{ __('Welcome back') }}</h2>
                    <p class="mt-1 text-center text-sm text-white/90">{{ __('Sign in to your account') }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                                <div class="mt-1">
                                    <input id="email" type="email" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                                <div class="mt-1">
                                    <input id="password" type="password" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Login as') }}</label>
                                <div class="mt-1">
                                    <select id="role" class="mt-1 block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm @error('role') border-red-500 @enderror" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="publisher" {{ old('role') == 'publisher' ? 'selected' : '' }}>Publisher</option>
                                        <option value="advertiser" {{ old('role') == 'advertiser' ? 'selected' : '' }}>Advertiser</option>
                                    </select>
                                </div>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-[#4361EE] focus:ring-[#4361EE] border-[#4895EF]/30 rounded" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="ml-2 block text-sm text-gray-700">{{ __('Remember Me') }}</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <div class="text-sm">
                                        <a href="{{ route('password.request') }}" class="font-medium text-[#4361EE] hover:text-[#3A0CA3] transition-colors duration-200">{{ __('Forgot Your Password?') }}</a>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] hover:from-[#3F37C9] hover:to-[#4895EF] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE] transform hover:-translate-y-0.5 transition-all duration-300">
                                    {{ __('Sign in') }}
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="text-sm text-gray-600">Don't have an account? 
                                    <a href="{{ route('register') }}" class="font-medium text-[#4361EE] hover:text-[#3A0CA3] transition-colors duration-200">Register here</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
