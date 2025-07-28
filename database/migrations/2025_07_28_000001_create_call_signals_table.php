<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('call_signals', function (Blueprint $table) {
            $table->id();
            $table->string('call_id');
            $table->unsignedInteger('sender_id');
            $table->enum('signal_type', ['offer', 'answer', 'ice-candidate', 'test']);
            $table->json('signal_data');
            $table->boolean('processed')->default(false);
            $table->timestamps();

            $table->foreign('sender_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->index(['call_id']);
            $table->index(['processed']);
            $table->index(['created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('call_signals');
    }
};
