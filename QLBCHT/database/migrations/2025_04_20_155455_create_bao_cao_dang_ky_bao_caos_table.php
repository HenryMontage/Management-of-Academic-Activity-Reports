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
        Schema::create('bao_cao_dang_ky_bao_caos', function (Blueprint $table) {
            $table->unsignedInteger('maDangKyBaoCao');
            $table->unsignedInteger('maBaoCao');
        
            $table->primary(['maDangKyBaoCao', 'maBaoCao']); // Khóa chính tổng hợp
        
            $table->foreign('maDangKyBaoCao')
                ->references('maDangKyBaoCao')
                ->on('dang_ky_bao_caos')
                ->onDelete('cascade');
        
            $table->foreign('maBaoCao')
                ->references('maBaoCao')
                ->on('bao_caos')
                ->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bao_cao_dang_ky_bao_caos');
    }
};
