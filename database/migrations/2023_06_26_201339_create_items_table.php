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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 100)->index()->comment('商品名');
            $table->tinyInteger('type')->comment('商品種別 1=RPG, 2=対戦, 3=育成, etc.');
            $table->tinyInteger('salesStatus')->comment('販売状況 1=販売中 2=生産終了 3=発売予定');
            $table->date('salesDate', 20)->comment('発売日');
            $table->integer('stock')->comment('在庫数');
            $table->integer('sdStock')->default(5)->comment('基準在庫');
            $table->text('detail')->nullable()->comment('商品紹介');
            $table->timestamps();
        
            // 外部キー制約を追加
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
