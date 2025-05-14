@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col justify-center py-6 sm:py-12">
    <div class="container-custom px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-xl">
                <div class="px-3 py-1 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20">
                    <h2 class="text-lg font-bold text-black text-center">{{ __('Create your account') }}</h2>
                    <p class="text-center text-xs text-black/90">{{ __('Join our platform today') }}</p>
                </div>
                <div class="p-4 space-y-3">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="space-y-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                <div class="mt-1">
                                    <input id="name" type="text" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                                <div class="mt-1">
                                    <input id="email" type="email" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div>
                                <label for="telegram_username" class="block text-sm font-medium text-gray-700">{{ __('Telegram Username') }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input id="telegram_username" type="text" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm @error('telegram_username') border-red-500 @enderror" name="telegram_username" value="{{ old('telegram_username') }}" required autocomplete="telegram_username" placeholder="https://t.me/username">
                                    
                                </div>
                                @error('telegram_username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                                <div class="mt-1">
                                    <input id="password" type="password" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div>
                                <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                                <div class="mt-1">
                                    <input id="password-confirm" type="password" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                        <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Register as') }}</label>
                                <div class="mt-1">
                                    <select id="role" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md @error('role') border-red-500 @enderror" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="publisher" {{ old('role') == 'publisher' ? 'selected' : '' }}>Publisher</option>
                                        <option value="advertiser" {{ old('role') == 'advertiser' ? 'selected' : '' }}>Advertiser</option>
                                    </select>
                                </div>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div class="mt-3">
                                <button type="submit" class="w-full flex justify-center py-1.5 px-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] hover:from-[#3F37C9] hover:to-[#4895EF] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE] transform hover:-translate-y-0.5 transition-all duration-300">
                                    {{ __('Create Account') }}
                                </button>
                            </div>
                    </form>
                    <div class="mt-3 text-center">
                        <p class="text-sm text-gray-600">
                            {{ __('Already have an account?') }}
                            <a href="{{ route('login') }}" class="font-medium text-[#4361EE] hover:text-[#3A0CA3] transition-colors duration-200">{{ __('Login here') }}</a>
                        </p>
                    </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
