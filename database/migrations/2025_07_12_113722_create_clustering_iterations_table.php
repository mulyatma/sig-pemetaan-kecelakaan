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
        Schema::create('clustering_iterations', function (Blueprint $table) {
            $table->id();
            $table->integer('iterasi');
            $table->string('kecamatan');
            $table->integer('jumlah_kasus');
            $table->integer('total_md');
            $table->integer('total_luka');
            $table->string('nama_klaster');
            $table->timestamps();
            for ($i = 1; $i <= 5; $i++) {
                $table->float('jarak_klaster_' . $i)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clustering_iterations');
    }
};
