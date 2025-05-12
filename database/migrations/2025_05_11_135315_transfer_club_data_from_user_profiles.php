<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Get all user profiles that have club information
        $clubProfiles = DB::table('user_profiles')
            ->whereNotNull('club_name')
            ->get();

        foreach ($clubProfiles as $profile) {
            // Check if a club with this name already exists
            $existingClub = DB::table('clubs')
                ->where('name', $profile->club_name)
                ->first();

            if (!$existingClub) {
                // Create new club record
                DB::table('clubs')->insert([
                    'name' => $profile->club_name,
                    'description' => $profile->club_description,
                    'logo' => $profile->club_logo,
                    'email' => DB::table('users')->where('id', $profile->user_id)->value('email'),
                    'website' => $profile->club_website,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // This is a data transfer migration, so we don't need to implement down()
    }
};
