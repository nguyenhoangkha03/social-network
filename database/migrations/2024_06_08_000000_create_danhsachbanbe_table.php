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
        Schema::create('danhsachbanbe', function (Blueprint $table) {
            $table->unsignedInteger('user_id_1');
            $table->unsignedInteger('user_id_2');
            $table->primary(['user_id_1', 'user_id_2']);
            $table->foreign('user_id_1')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_2')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danhsachbanbe');
    }
};
