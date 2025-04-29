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
        Schema::table('nhan_vien_p_d_b_c_ls', function (Blueprint $table) {
            $table->string('anhDaiDien')->nullable()->after('matKhau');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nhan_vien_p_d_b_c_ls', function (Blueprint $table) {
            //
        });
    }
};
