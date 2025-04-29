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

        Schema::create('giang_viens', function (Blueprint $table) {
            $table->string('maGiangVien')->primary()->unique();
            $table->string('ho', 20);
            $table->string('ten', 20);            
            $table->string('sdt', 15)->unique();
            $table->string('email', 100)->unique();
            $table->string('matKhau', 100);
            $table->unsignedInteger('chucVu')->nullable();
            $table->foreign('chucVu')->references('maChucVu')->on('chuc_vus')->onDelete('SET NULL');
            $table->string('boMon_id')->nullable();
            $table->foreign('boMon_id')->references('maBoMon')->on('bo_mons')->onDelete('SET NULL');
            $table->string('anhDaiDien')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giang_viens');
    }
};
