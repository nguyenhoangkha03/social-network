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
        Schema::create('chanel_block', function (Blueprint $table) {
            $table->increments('id_chanel_block');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('id_chanel');
            $table->timestamp('taoluc')->nullable();
            $table->timestamp('capnhatluc')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('id_chanel')->references('id_chanel')->on('chanel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chanel_block');
    }
};
