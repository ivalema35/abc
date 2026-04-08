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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities')->restrictOnDelete();
            $table->string('name');
            $table->string('contact', 20);
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('login_pin', 4)->comment('4-digit login PIN');
            $table->string('rfid_start')->nullable();
            $table->string('rfid_end')->nullable();
            $table->integer('net_quantity')->default(0);
            $table->string('image')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
