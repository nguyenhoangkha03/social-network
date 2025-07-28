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
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('follower_id'); // Người follow
            $table->unsignedInteger('following_id'); // Người được follow
            $table->timestamps();

            $table->unique(['follower_id', 'following_id']);
            $table->foreign('follower_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('following_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
