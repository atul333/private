<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $user = auth()->user();
        return $user->role === 'publisher' 
            ? route('publisher.dashboard', ['user' => $user->id])
            : route('advertiser.dashboard', ['user' => $user->id]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telegram_username' => [
                'required',
                'string',
                'regex:/^https:\/\/t\.me\/[a-zA-Z0-9_]{5,32}$/',
                'unique:users,telegram_username'
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:publisher,advertiser'],
        ], [
            'telegram_username.regex' => 'Telegram username must start with https://t.me/ followed by your username',
            'telegram_username.min' => 'Telegram username must be at least 5 characters',
            'telegram_username.max' => 'Telegram username cannot exceed 32 characters'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'telegram_username' => $data['telegram_username'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        if ($data['role'] === 'publisher') {
            $user->publisher()->create();
        } else {
            $user->advertiser()->create(['company_name' => $data['name']]);
            
            $wallet = $user->wallet()->create([
                'name' => 'default',
                'slug' => 'default',
                'balance' => 0,
            ]);

            if (!$wallet) {
                Log::error("Failed to create wallet for advertiser: {$user->id}");
            }
        }

        return $user;
    }
}
