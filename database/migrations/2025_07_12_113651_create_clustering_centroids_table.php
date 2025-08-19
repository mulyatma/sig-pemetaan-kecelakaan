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
        Schema::create('clustering_centroids', function (Blueprint $table) {
            $table->id();
            $table->string('nama_klaster');
            $table->integer('jumlah_kasus');
            $table->integer('total_md');
            $table->integer('total_luka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clustering_centroids');
    }
};
