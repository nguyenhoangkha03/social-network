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
        Schema::create('chanel', function (Blueprint $table) {
            $table->increments('id_chanel');
            $table->string('tenkenh', 200);
            $table->unsignedInteger('nguoisohuu');
            $table->binary('hinhanh_avatar')->nullable();
            $table->binary('hinhanh_cover')->nullable();
            $table->timestamp('thoigiantao')->nullable();
            $table->timestamp('thoigiancapnhat')->nullable();
            $table->integer('loaikenh')->nullable();

            $table->foreign('nguoisohuu')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chanel');
    }
}; 