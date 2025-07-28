<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kiểm tra và xóa cột id_nguoinhan nếu tồn tại (vì receiver_id đã có sẵn từ migration gốc)
        Schema::table('tinnhan', function (Blueprint $table) {
            if (Schema::hasColumn('tinnhan', 'id_nguoinhan')) {
                $table->dropColumn('id_nguoinhan');
            }
        });
    }

    public function down(): void
    {
        // Rollback: thêm lại cột id_nguoinhan nếu cần
        Schema::table('tinnhan', function (Blueprint $table) {
            if (!Schema::hasColumn('tinnhan', 'id_nguoinhan')) {
                $table->unsignedInteger('id_nguoinhan')->nullable()->after('user_id');
            }
        });
    }
};
