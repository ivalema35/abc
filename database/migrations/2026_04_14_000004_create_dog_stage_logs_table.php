<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dog_stage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catching_record_id')->constrained('catching_records')->cascadeOnDelete();
            $table->string('stage'); // e.g., 'Caught', 'In Process', 'Observation', 'R4R', 'Expired', 'Completed', 'Rejected'
            $table->foreignId('action_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable(); // Remarks on why the transition happened
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dog_stage_logs');
    }
};
