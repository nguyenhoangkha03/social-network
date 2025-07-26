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
        Schema::create('user_chanel', function (Blueprint $table) {
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_chanel');
            $table->primary(['id_user', 'id_chanel']);

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_chanel')->references('id_chanel')->on('chanel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chanel');
    }
}; 