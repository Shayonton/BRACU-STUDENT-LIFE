<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_code')->unique();
            $table->integer('floor');
            $table->string('block');
            $table->string('room_number');
            $table->enum('room_type', ['C', 'L', 'A', 'M', 'T', 'CR']); // C=Classroom, L=Lab, A=Auditorium, M=Multipurpose, T=Theater, CR=Club Room
            $table->integer('capacity');
            $table->json('features')->nullable();
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}; 