@extends('layouts.app')

@section('content')
<div class="flex min-h-full flex-col justify-center bg-gray-50 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full mx-auto space-y-4">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">{{ __('Welcome back') }}</h2>
            <p class="mt-2 text-center text-sm text-gray-600">{{ __('Sign in to your account') }}</p>
        </div>
        <div class="mt-4 bg-white py-6 px-4 shadow-xl sm:rounded-lg sm:px-10">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                                <div class="mt-1">
                                    <input id="email" type="email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                                <div class="mt-1">
                                    <input id="password" type="password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Login as') }}</label>
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

                        <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="ml-2 block text-sm text-gray-900">{{ __('Remember Me') }}</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <div class="text-sm">
                                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('Forgot Your Password?') }}</a>
                                    </div>
                                @endif
                            </div>

                        <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Sign in') }}
                                </button>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Don't have an account? 
                                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Register here</a>
                                </p>
                            </div>
                    </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
