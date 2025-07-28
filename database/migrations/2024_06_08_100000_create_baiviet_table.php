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
        Schema::create('baiviet', function (Blueprint $table) {
            $table->char('id_baiviet', 10)->primary();
            $table->unsignedInteger('user_id');
            $table->string('tieude', 255);
            $table->text('mota')->nullable();
            $table->text('noidung')->nullable();
            $table->string('anh_bia', 255)->nullable();
            $table->string('dinhkhem', 255)->nullable();
            $table->timestamp('thoigiandang')->nullable();
            $table->timestamp('thoigiancapnhat')->nullable();
            $table->integer('soluotlike')->default(0);

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baiviet');
    }
};
