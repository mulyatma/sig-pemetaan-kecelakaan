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
        Schema::create('rekap_kecamatan', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan')->unique();
            $table->integer('jumlah_kasus')->default(0);
            $table->integer('total_md')->default(0);
            $table->integer('total_luka')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_kecamatan');
    }
};
