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
        Schema::create('ivr_audio_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ivr_config_id')->constrained('ivr_configurations')->onDelete('cascade');
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ivr_audio_files');
    }
};
