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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 操作したユーザーのID
            $table->string('target_type'); // 編集対象の種類 (例: 'user', 'item')
            $table->unsignedBigInteger('target_id')->nullable(); // 操作対象のID
            $table->json('action'); // 編集内容 (例: 'update_role', 'update_item')
            $table->json('before_value')->nullable(); // 変更前の値
            $table->json('after_value')->nullable(); // 変更後の値
            $table->string('memo', 100)->nullable(); // 補足情報
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
