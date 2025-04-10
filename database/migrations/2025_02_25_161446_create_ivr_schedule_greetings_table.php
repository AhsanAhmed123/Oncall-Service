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
        Schema::create('ivr_schedule_greetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ivr_config_id'); 
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time')->nullable();
            $table->string('title');
            $table->text('greeting_text')->nullable();
            $table->string('greeting_audio', 255);
            $table->timestamps();

            $table->foreign('ivr_config_id')->references('id')->on('ivr_configurations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ivr_schedule_greetings');
    }
};
