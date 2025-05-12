<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Create student user
DB::table('users')->insert([
    'name' => 'Test Student',
    'email' => 'teststudent@g.bracu.ac.bd',
    'student_id' => '22222222',
    'password' => Hash::make('password123'),
    'user_type' => 'student',
    'created_at' => now(),
    'updated_at' => now()
]);

echo "Test student created successfully!\n";
echo "Email: teststudent@g.bracu.ac.bd\n";
echo "Password: password123\n"; 