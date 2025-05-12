<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Verifying Club Data Transfer...\n\n";

// Get clubs from user_profiles
$userProfileClubs = DB::table('user_profiles')
    ->whereNotNull('club_name')
    ->get(['club_name', 'club_description', 'club_website']);

echo "Clubs in user_profiles:\n";
foreach ($userProfileClubs as $club) {
    echo "- {$club->club_name}\n";
}

echo "\nClubs in clubs table:\n";
$transferredClubs = DB::table('clubs')->get(['name', 'description', 'website']);
foreach ($transferredClubs as $club) {
    echo "- {$club->name}\n";
}

echo "\nVerification complete.\n"; 