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
        Schema::create('lich_bao_cao_giang_vien', function (Blueprint $table) {
            $table->unsignedInteger('lich_bao_cao_id');
            $table->string('giang_vien_id'); 

            $table->foreign('lich_bao_cao_id')->references('maLich')->on('lich_bao_caos')->onDelete('cascade');
            $table->foreign('giang_vien_id')->references('maGiangVien')->on('giang_viens')->onDelete('cascade');
            
            $table->primary(['lich_bao_cao_id', 'giang_vien_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_bao_cao_giang_vien');
    }
};
