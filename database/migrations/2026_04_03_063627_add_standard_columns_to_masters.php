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
        if (!Schema::hasColumn('cities', 'is_active')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->tinyInteger('is_active')->default(1)->comment('0=Inactive, 1=Active')->after('image');
            });
        }

        if (!Schema::hasColumn('cities', 'deleted_at')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('ngos', 'is_active')) {
            Schema::table('ngos', function (Blueprint $table) {
                $table->tinyInteger('is_active')->default(1)->comment('0=Inactive, 1=Active')->after('image');
            });
        }

        if (!Schema::hasColumn('ngos', 'deleted_at')) {
            Schema::table('ngos', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('cities', 'deleted_at')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasColumn('cities', 'is_active')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        if (Schema::hasColumn('ngos', 'deleted_at')) {
            Schema::table('ngos', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasColumn('ngos', 'is_active')) {
            Schema::table('ngos', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};
