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
        Schema::create('kecelakaan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_dilaporkan')->nullable();
            $table->string('tingkat_kecelakaan')->nullable();
            $table->integer('md')->nullable();
            $table->integer('lb')->nullable();
            $table->integer('lr')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('nama_jalan')->nullable();
            $table->string('status_jalan')->nullable();
            $table->string('penyebab')->nullable();
            $table->string('rumat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecelakaan');
    }
};
