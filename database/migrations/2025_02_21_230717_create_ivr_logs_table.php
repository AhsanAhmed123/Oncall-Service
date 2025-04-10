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
        Schema::create('ivr_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ivr_config_id')->constrained('ivr_configurations')->onDelete('cascade');
            $table->string('caller_number', 20);
            $table->integer('selected_option');
            $table->integer('call_duration');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ivr_logs');
    }
};
