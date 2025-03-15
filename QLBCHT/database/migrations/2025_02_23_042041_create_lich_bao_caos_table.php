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

        Schema::create('lich_bao_caos', function (Blueprint $table) {
            $table->increments('maLich');
            $table->date('ngayBaoCao');
            $table->time('gioBaoCao');
            $table->string('chuDe');
            $table->string('giangVienPhuTrach_id')->nullable();
            $table->foreign('giangVienPhuTrach_id')->references('maGiangVien')->on('giang_viens')->onDelete('SET NULL'); 
            $table->date('hanNgayNop');
            $table->time('hanGioNop');
            $table->string('boMon_id')->nullable();
            $table->foreign('boMon_id')->references('maBoMon')->on('bo_mons')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_bao_caos');
    }
};
