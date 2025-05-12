<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('club_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('application_note')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            
            // Ensure a user can only be a member of a club once
            $table->unique(['user_id', 'club_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('club_members');
    }
}; 