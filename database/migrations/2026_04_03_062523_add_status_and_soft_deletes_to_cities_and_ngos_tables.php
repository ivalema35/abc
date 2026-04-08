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
        Schema::table('cities', function (Blueprint $table) {
            $table->tinyInteger('is_active')->default(1)->comment('0=Inactive, 1=Active')->after('image');
            $table->softDeletes();
        });

        Schema::table('ngos', function (Blueprint $table) {
            $table->tinyInteger('is_active')->default(1)->comment('0=Inactive, 1=Active')->after('image');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropSoftDeletes();
        });

        Schema::table('ngos', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropSoftDeletes();
        });
    }
};
