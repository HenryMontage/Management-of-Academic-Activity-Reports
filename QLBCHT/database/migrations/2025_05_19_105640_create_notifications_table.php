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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('loai'); // 'lich', 'bien_ban', 'phieu_dang_ky'
            $table->string('noiDung');
            $table->string('link')->nullable(); // link tới trang index tương ứng
            $table->boolean('daDoc')->default(false);
            $table->string('doiTuong')->nullable(); // 'giang_vien', 'nhan_vien', 'truong_bo_mon', ...
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
