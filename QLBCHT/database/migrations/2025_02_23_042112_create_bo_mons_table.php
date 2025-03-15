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

        Schema::create('bo_mons', function (Blueprint $table) {
            $table->string('maBoMon')->primary();
            $table->string('tenBoMon');
            $table->string('maKhoa')->nullable();
            $table->foreign('maKhoa')->references('maKhoa')->on('khoas')->onDelete('SET NULL');
            $table->string('truongBoMon')->nullable(); // Thêm trưởng bộ môn
            $table->foreign('truongBoMon')->references('maGiangVien')->on('giang_viens')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bo_mons');
    }
};
