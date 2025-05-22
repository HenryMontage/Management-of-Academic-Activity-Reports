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

        Schema::create('chuc_vus', function (Blueprint $table) {
            $table->string('maChucVu')->primary();
            $table->string('tenChucVu');
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
        Schema::dropIfExists('chuc_vus');
    }
};
