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

        Schema::create('admins', function (Blueprint $table) {
            $table->string('maAdmin')->primary()->unique();
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

        // Insert dữ liệu admin mặc định
        DB::table('admins')->insert([
            [
                'maAdmin' => 'AD001', // thêm maAdmin vì giờ nó là PRIMARY KEY
                'ho' => 'Nguyễn Hoàng',
                'ten' => 'Anh',
                'sdt' => '023215458',
                'email' => 'hoanganh123@gmail.com',
                'matKhau' => bcrypt('12345678'),
                'quyen_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
