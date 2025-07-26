<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tinnhan', function (Blueprint $table) {
            $table->increments('id_tinnhan');
            $table->unsignedInteger('user_id'); // người gửi
            $table->unsignedInteger('receiver_id'); // người nhận

            $table->text('noidung')->nullable(); // nội dung văn bản
            $table->string('hinhanh')->nullable(); // đường dẫn ảnh nếu có

            $table->timestamp('thoigiantao')->nullable();
            $table->timestamp('thoigiancapnhat')->nullable();
            $table->string('trangthaixoa', 255)->nullable();

            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tinnhan');
    }
};
