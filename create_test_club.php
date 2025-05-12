<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Create club user
$clubUser = DB::table('users')->insertGetId([
    'name' => 'Test Club',
    'email' => 'testclub@bracu.ac.bd',
    'student_id' => '12345678',
    'club_representative_id' => '87654321',
    'phone_number' => '+8801712345678',
    'club_representative_phone' => '+8801787654321',
    'password' => Hash::make('password123'),
    'user_type' => 'club',
    'created_at' => now(),
    'updated_at' => now()
]);

// Create club record
DB::table('clubs')->insert([
    'name' => 'Test Club',
    'email' => 'testclub@bracu.ac.bd',
    'phone' => '+8801712345678',
    'description' => 'A test club for demonstration',
    'created_at' => now(),
    'updated_at' => now()
]);

echo "Test club created successfully!\n";
echo "Email: testclub@bracu.ac.bd\n";
echo "Password: password123\n"; 