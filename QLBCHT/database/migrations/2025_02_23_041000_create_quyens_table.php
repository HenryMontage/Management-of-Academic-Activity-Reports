<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('quyens', function (Blueprint $table) {
            $table->increments('maQuyen');
            $table->string('tenQuyen');
            $table->json('nhomRoute')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Insert dữ liệu mặc định
        DB::table('quyens')->insert([
            [
                'tenQuyen' => 'Quản Trị Viên',
                'nhomRoute' => json_encode([
                    'admin','nhanvien','giangvien','khoa',
                    'bomon','chucvu','quyen','email','lichbaocao',
                    'dangkybaocao','baocao','bienban','duyet','xacnhan'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quyens');
    }
};
