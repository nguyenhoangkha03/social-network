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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id'); // Người nhận thông báo
            $table->string('type'); // Loại thông báo: friend_request, like, comment, message
            $table->json('data')->nullable(); // Dữ liệu chi tiết (tên người gửi, id bài viết, ...)
            $table->boolean('is_read')->default(false); // Đã đọc hay chưa
            $table->timestamps();

            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
