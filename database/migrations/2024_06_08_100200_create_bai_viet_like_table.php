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
        Schema::create('bai_viet_like', function (Blueprint $table) {
            $table->unsignedInteger('id_user');
            $table->char('id_baiviet', 10);
            $table->primary(['id_user', 'id_baiviet']);

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_baiviet')->references('id_baiviet')->on('baiviet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bai_viet_like');
    }
}; 