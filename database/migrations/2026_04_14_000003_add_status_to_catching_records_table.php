<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catching_records', function (Blueprint $table) {
            if (! Schema::hasColumn('catching_records', 'status')) {
                $table->enum('status', ['Caught', 'In Process', 'Observation', 'Completed', 'Rejected'])
                    ->default('Caught')
                    ->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('catching_records', function (Blueprint $table) {
            if (Schema::hasColumn('catching_records', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
