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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('bd_title')->nullable();
            $table->string('bd_logo', 500)->nullable();
            $table->string('bd_email')->nullable();
            $table->string('bd_contact', 20)->nullable();
            $table->text('bd_address')->nullable();
            $table->string('bd_location')->nullable();
            $table->string('bd_support_mail')->nullable();
            $table->string('sms_meta')->nullable();
            $table->string('sms_logo', 500)->nullable();
            $table->string('sms_email')->nullable();
            $table->string('sms_contact', 20)->nullable();
            $table->text('sms_address')->nullable();
            $table->string('sms_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
