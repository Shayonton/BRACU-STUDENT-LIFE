<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pre_registered');
            $table->timestamps();
            
            $table->unique(['event_id', 'user_id']);
        });

        // Add foreign key constraint after events table is created
        Schema::table('participants', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('participants');
    }
}; 