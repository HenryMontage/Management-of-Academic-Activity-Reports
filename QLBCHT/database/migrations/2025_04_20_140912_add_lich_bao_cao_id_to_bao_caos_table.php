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
        Schema::table('bao_caos', function (Blueprint $table) {
            $table->unsignedInteger('lich_bao_cao_id')->nullable()->after('giangVien_id');
            $table->foreign('lich_bao_cao_id')->references('maLich')->on('lich_bao_caos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bao_caos', function (Blueprint $table) {
            $table->dropForeign(['lich_bao_cao_id']);
            $table->dropColumn('lich_bao_cao_id');
        });
    }
};
