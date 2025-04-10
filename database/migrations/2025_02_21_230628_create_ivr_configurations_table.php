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
        Schema::create('ivr_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('did_number', 20);
            $table->string('business_phone', 20);
            $table->string('ivr_type', 20);
            $table->string('tts_type', 20)->nullable();
            $table->text('main_greeting');
            $table->integer('repeat_count');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ivr_configurations');
    }
};
