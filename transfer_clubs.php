<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Get all club users
$clubUsers = DB::table('users')
    ->where('user_type', 'club')
    ->get();

foreach ($clubUsers as $user) {
    // Check if club already exists
    $existingClub = DB::table('clubs')
        ->where('email', $user->email)
        ->first();

    if (!$existingClub) {
        // Create new club record
        DB::table('clubs')->insert([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone_number,
            'description' => 'Club transferred from users table',
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);
        echo "Created club for: " . $user->name . " (keeping original user record)\n";
    } else {
        echo "Club already exists for: " . $user->name . " (keeping original user record)\n";
    }
}

echo "Transfer complete! All club data is now in both tables.\n"; 