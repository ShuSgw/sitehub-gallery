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
        Schema::create('screenshot_logs', function (Blueprint $table) {
            $table->id();
            // どのユーザーのスクショか
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            // どのURLか
            $table->string('url', 2048);
            // 撮影が成功したか
            $table->boolean('success')->default(false);
            // タイムスタンプ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screenshot_logs');
    }
};
