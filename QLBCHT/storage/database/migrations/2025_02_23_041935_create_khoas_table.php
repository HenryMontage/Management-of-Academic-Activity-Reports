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

        Schema::create('khoas', function (Blueprint $table) {
            $table->string('maKhoa')->primary();
            $table->string('tenKhoa');
            $table->string('truongKhoa')->nullable(); // Thêm trưởng khoa
            $table->foreign('truongKhoa')->references('maGiangVien')->on('giang_viens')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khoas');
    }
};
