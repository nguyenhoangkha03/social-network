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
        Schema::create('binhluan', function (Blueprint $table) {
            $table->increments('id_binhluan');
            $table->unsignedInteger('id_user');
            $table->char('id_baiviet', 10);
            $table->text('noidung');
            $table->timestamp('thoigiantao')->nullable();
            $table->unsignedInteger('parent_id')->nullable(); // chỉ cho phép 2 cấp

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_baiviet')->references('id_baiviet')->on('baiviet')->onDelete('cascade');
            $table->foreign('parent_id')->references('id_binhluan')->on('binhluan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binhluan');
    }
}; 