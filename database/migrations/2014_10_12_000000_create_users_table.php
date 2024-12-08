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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1)->comment('状態 1=active, 0=deleted'); 
            $table->tinyInteger('role')->default(3)->comment('権限 1=管理者, 2=編集者, 3=閲覧者, 4=停止');
            $table->tinyInteger('department')->nullable()->comment('部署 1=商品管理部, 2=営業部, 3=商品開発部, 4=その他');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
