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
        Schema::table('dang_ky_bao_caos', function (Blueprint $table) {
            $table->string('giangVien_id')->nullable()->after('lichBaoCao_id');

            // Thiết lập khóa ngoại
            $table->foreign('giangVien_id')
                  ->references('maGiangVien')
                  ->on('giang_viens')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_bao_caos', function (Blueprint $table) {
            $table->dropForeign(['giangVien_id']);
            $table->dropColumn('giangVien_id');
        });
    }
};
