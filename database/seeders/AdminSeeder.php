<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bracu.ac.bd',
            'password' => Hash::make('admin123'), // Change this password in production
            'user_type' => 'admin'
        ]);
    }
} 