<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baiviet', function (Blueprint $table) {
            $table->unsignedInteger('pinned_comment_id')->nullable();
            $table->foreign('pinned_comment_id')->references('id_binhluan')->on('binhluan')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::table('baiviet', function (Blueprint $table) {
            $table->dropForeign(['pinned_comment_id']);
            $table->dropColumn('pinned_comment_id');
        });
    }
}; 