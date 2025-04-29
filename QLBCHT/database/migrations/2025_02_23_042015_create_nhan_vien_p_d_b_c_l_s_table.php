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

        Schema::create('nhan_vien_p_d_b_c_ls', function (Blueprint $table) {
            $table->string('maNV')->primary()->unique();
            $table->string('ho', 20);
            $table->string('ten', 20);            
            $table->string('sdt', 15)->unique();
            $table->string('email', 100)->unique();
            $table->string('matKhau', 100);
            $table->unsignedInteger('quyen_id')->nullable();
            $table->foreign('quyen_id')->references('maQuyen')->on('quyens')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_vien_p_d_b_c_ls');
    }
};
