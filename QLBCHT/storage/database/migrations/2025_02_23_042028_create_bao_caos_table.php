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

        Schema::create('bao_caos', function (Blueprint $table) {
            $table->unsignedInteger('maBaoCao')->autoIncrement(); // Đảm bảo là unsignedInteger
            $table->string('tenBaoCao');
            $table->dateTime('ngayNop');
            $table->string('dinhDang');
            $table->text('tomTat');
            $table->text('duongDanFile');
            $table->string('giangVien_id')->nullable();
            $table->foreign('giangVien_id')->references('maGiangVien')->on('giang_viens')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bao_caos');
    }
};
