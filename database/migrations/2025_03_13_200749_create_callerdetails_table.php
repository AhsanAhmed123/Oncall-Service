<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('callerdetails', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('dob')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('notes')->nullable();
            $table->integer('call_recording_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callerdetails');
    }
};
