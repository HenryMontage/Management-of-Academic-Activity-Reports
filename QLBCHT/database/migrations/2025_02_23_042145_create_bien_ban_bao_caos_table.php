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
        Schema::disableForeignKeyConstraints();

        Schema::create('bien_ban_bao_caos', function (Blueprint $table) {
            $table->string('maBienBan')->unique();
            $table->dateTime('ngayNop');
            $table->text('fileBienBan');
            $table->unsignedInteger('lichBaoCao_id')->nullable();
            $table->foreign('lichBaoCao_id')->references('maLich')->on('lich_bao_caos')->onDelete('SET NULL');
            $table->string('trangThai')->default('Chờ Duyệt');
            $table->string('nhanVien_id')->nullable();
            $table->foreign('nhanVien_id')->references('maNV')->on('nhan_vien_p_d_b_c_ls')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bien_ban_bao_caos');
    }
};
