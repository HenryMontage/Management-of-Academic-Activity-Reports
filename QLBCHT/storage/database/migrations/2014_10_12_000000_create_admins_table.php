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
            $table->increments('maAdmin');
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

        // DB::table('admins')->insert([
        //     [
        //         'ho' => 'Nguyễn Hoàng',
        //         'ten' => 'Anh',
        //         'sdt' => '023215458',
        //         'email' => 'hoanganh123@gmail.com',
        //         'matKhau' => bcrypt('12345678'),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
