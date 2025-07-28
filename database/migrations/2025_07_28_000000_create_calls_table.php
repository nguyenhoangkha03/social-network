<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->string('call_id')->unique();
            $table->unsignedInteger('caller_id');
            $table->unsignedInteger('receiver_id');
            $table->enum('call_type', ['voice', 'video']);
            $table->enum('status', ['initiating', 'ringing', 'connected', 'ended', 'declined', 'missed']);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->json('signaling_data')->nullable();
            $table->timestamps();

            $table->foreign('caller_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->index(['caller_id', 'receiver_id']);
            $table->index(['status']);
            $table->index(['created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('calls');
    }
};
