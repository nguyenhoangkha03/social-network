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
            $table->increments('id_user');
            $table->string('username', 200)->unique();
            $table->string('password', 200);
            $table->string('hoten', 200)->nullable();
            $table->string('diachi', 200)->nullable();
            $table->integer('gioitinh')->nullable();
            $table->binary('hinhanh')->nullable();
            $table->timestamp('ngaytao')->useCurrent();
            $table->timestamp('ngaycapnhat')->useCurrent()->nullable();
            $table->string('email', 200)->unique();
            $table->integer('sodienthoai')->nullable();
            $table->boolean('trangthai')->default(true);
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
