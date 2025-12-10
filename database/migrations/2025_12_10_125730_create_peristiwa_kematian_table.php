<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peristiwa_kematian', function (Blueprint $table) {
            $table->id('kematian_id');
            $table->unsignedBigInteger('warga_id');

            // Data kematian
            $table->date('tgl_meninggal')->nullable();
            $table->string('sebab', 100)->nullable();
            $table->string('lokasi', 100)->nullable();
            $table->string('no_surat')->unique()->nullable();

            // Timestamps
            $table->timestamps();

            // Foreign key constraint - SESUAIKAN DENGAN TABEL warga ANDA
            $table->foreign('warga_id')
                  ->references('warga_id')  // Sesuai dengan primary key di tabel warga
                  ->on('warga')  // Nama tabel: warga (bukan wargas)
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peristiwa_kematian');
    }
};
