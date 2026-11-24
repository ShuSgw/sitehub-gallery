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
        if (! Schema::hasColumn('sites', 'screenshot_failed_at')) {
            Schema::table('sites', function (Blueprint $table) {
                $table->timestamp('screenshot_failed_at')->nullable()->after('screenshot_path');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sites', 'screenshot_failed_at')) {
            Schema::table('sites', function (Blueprint $table) {
                $table->dropColumn('screenshot_failed_at');
            });
        }
    }
};
