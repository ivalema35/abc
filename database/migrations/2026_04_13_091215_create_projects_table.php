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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ngo_id')->constrained('ngos');
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('hospital_id')->constrained('hospitals');
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->string('name');
            $table->boolean('rfid_enabled')->default(0);
            $table->string('contact', 20)->nullable();
            $table->string('pin', 4)->nullable();
            $table->unsignedInteger('arv_months')->nullable()->default(6);

            // 14 Permission Toggles
            $table->enum('catch_visibility', ['visible', 'hidden'])->default('visible');
            $table->enum('catch_type', ['count', 'list'])->default('list');
            $table->enum('receive_visibility', ['visible', 'hidden'])->default('visible');
            $table->enum('receive_type', ['count', 'list'])->default('count');
            $table->enum('process_visibility', ['visible', 'hidden'])->default('visible');
            $table->enum('process_type', ['count', 'list'])->default('count');
            $table->enum('observation_visibility', ['visible', 'hidden'])->default('visible');
            $table->enum('observation_type', ['count', 'list'])->default('count');
            $table->enum('r4r_visibility', ['visible', 'hidden'])->default('visible');
            $table->enum('r4r_type', ['count', 'list'])->default('count');
            $table->enum('complete_visibility', ['visible', 'hidden'])->default('visible');
            $table->enum('complete_type', ['count', 'list'])->default('list');
            $table->enum('reject_visibility', ['visible', 'hidden'])->default('visible');
            $table->enum('reject_type', ['count', 'list'])->default('count');

            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
