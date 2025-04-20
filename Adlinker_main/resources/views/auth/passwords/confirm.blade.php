@extends('layouts.app')

@section('content')
<div class="h-full bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl">
                <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20">
                    <h2 class="text-xl font-bold text-black text-center">{{ __('Confirm Password') }}</h2>
                    <p class="mt-1 text-center text-sm text-black/90">{{ __('Please confirm your password before continuing.') }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                                <div class="mt-1">
                                    <input id="password" type="password" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] hover:from-[#3F37C9] hover:to-[#4895EF] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE] transform hover:-translate-y-0.5 transition-all duration-300">
                                    {{ __('Confirm Password') }}
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-center mt-4">
                                    <a href="{{ route('password.request') }}" class="font-medium text-[#4361EE] hover:text-[#3A0CA3] transition-colors duration-200">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
