<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. 新しいカラムを追加
        Schema::table('items', function (Blueprint $table) {
            $table->string('title')->after('name'); // 新しいカラムを作成
        });

        // 2. nameカラムの値をtitleカラムにコピー
        DB::table('items')->update(['title' => DB::raw('name')]); // 値をコピー

        // 3. 古いカラムを削除
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('name'); // 古いカラムを削除
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 逆の操作を定義する（任意）
        Schema::table('items', function (Blueprint $table) {
            $table->string('name')->after('title'); // nameカラムを再作成
        });

        DB::table('items')->update(['name' => DB::raw('title')]); // titleの値をnameにコピー

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('title'); // titleカラムを削除
        });
    }
};
