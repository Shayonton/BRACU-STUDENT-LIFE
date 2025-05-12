<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
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
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::table('users')->where('email', 'admin@bracu.ac.bd')->delete();
    }
}; 