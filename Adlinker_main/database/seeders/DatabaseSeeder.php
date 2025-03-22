<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'dheeraj@123',
            'email' => 'dheeraj@123',
            'password' => \Illuminate\Support\Facades\Hash::make('dheeraj@123'),
            'role' => 'advertiser'
        ]);
    }
}
