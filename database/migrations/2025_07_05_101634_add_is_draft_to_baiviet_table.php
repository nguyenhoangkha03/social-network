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
        Schema::table('baiviet', function (Blueprint $table) {
            $table->boolean('is_draft')->default(false)->after('soluotlike');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baiviet', function (Blueprint $table) {
            $table->dropColumn('is_draft');
        });
    }
};
