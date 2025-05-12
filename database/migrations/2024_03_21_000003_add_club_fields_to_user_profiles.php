<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('club_name')->nullable();
            $table->string('club_description')->nullable();
            $table->string('club_website')->nullable();
            $table->string('club_facebook')->nullable();
            $table->string('club_instagram')->nullable();
            $table->string('club_logo')->nullable();
            $table->json('club_members')->nullable();
        });
    }

    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'club_name',
                'club_description',
                'club_website',
                'club_facebook',
                'club_instagram',
                'club_logo',
                'club_members'
            ]);
        });
    }
}; 