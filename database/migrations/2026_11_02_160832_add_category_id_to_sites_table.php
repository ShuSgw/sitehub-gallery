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
        Schema::table('sites', function (Blueprint $table) {
            $table
                // 外部キー用のカラム(category_id)を作る
                ->foreignId('category_id')
                // 空(null)を許可する。既存のSiteにはカテゴリがないため必須
                ->nullable()
                // categoriesテーブルのidを参照する外部キー制約を付ける
                ->constrained()
                // 参照先のカテゴリが削除されたら、Siteは残して category_id を null にする
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table
                // 外部キー制約とカラム(category_id)をまとめて削除する
                ->dropConstrainedForeignId('category_id');
        });
    }
};
