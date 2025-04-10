<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->integer('user_id');
            $table->text('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('website')->nullable();
            $table->string('password');
            $table->string('designation')->nullable();
            $table->text('agent_notes')->nullable();
            $table->text('fax_numbers')->nullable();
            $table->text('bulk_sms')->nullable();
            $table->text('agent_greeting')->nullable();
            $table->string('obituary_link')->nullable();
            $table->text('bulk_emails')->nullable();
            $table->string('directions_link')->nullable();
            $table->string('business_phone')->nullable();
            $table->boolean('did_config')->default(false);
            $table->string('did_number')->nullable();
            $table->boolean('callback_required')->default(false);
            $table->string('call_person_name')->nullable();
            $table->enum('send_reminder_tx', ['yes', 'no'])->nullable();
            $table->integer('seconds_past')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
