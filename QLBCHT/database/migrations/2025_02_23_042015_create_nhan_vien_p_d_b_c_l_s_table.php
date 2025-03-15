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
            $table->increments('maNV');
            $table->string('ho');
            $table->string('ten');
            $table->string('sdt')->unique();
            $table->string('email')->unique();
            $table->string('matKhau');
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
