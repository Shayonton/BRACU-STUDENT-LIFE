<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Contracts\Console\Kernel;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Check if admin already exists
$exists = DB::table('users')->where('email', 'admin@bracu.ac.bd')->exists();

if (!$exists) {
    DB::table('users')->insert([
        'name' => 'Admin',
        'email' => 'admin@bracu.ac.bd',
        'password' => Hash::make('admin123'),
        'user_type' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Admin user created successfully.\n";
} else {
    echo "Admin user already exists.\n";
} 