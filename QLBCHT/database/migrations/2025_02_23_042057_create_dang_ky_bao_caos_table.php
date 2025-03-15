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

        Schema::create('dang_ky_bao_caos', function (Blueprint $table) {
            $table->increments('maDangKyBaoCao');
            $table->dateTime('ngayDangKy');
            $table->string('trangThai')->default('Chờ Duyệt');
            $table->unsignedInteger('lichBaoCao_id')->nullable();
            $table->foreign('lichBaoCao_id')->references('maLich')->on('lich_bao_caos')->onDelete('SET NULL');
            $table->unsignedInteger('baoCao_id')->nullable(); 
            $table->foreign('baoCao_id')->references('maBaoCao')->on('bao_caos')->onDelete('SET NULL');
            $table->mediumText('ketQuaGopY')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dang_ky_bao_caos');
    }
};
