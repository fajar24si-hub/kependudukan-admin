<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peristiwa_pindah', function (Blueprint $table) {
            $table->id('pindah_id');
            $table->foreignId('warga_id')->constrained('warga', 'warga_id')->onDelete('cascade');
            $table->date('tgl_pindah');
            $table->string('alamat_tujuan', 255);
            $table->string('kecamatan_tujuan', 100);
            $table->string('kabupaten_tujuan', 100);
            $table->string('provinsi_tujuan', 100);
            $table->string('negara_tujuan', 100)->default('Indonesia');
            $table->text('alasan');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('no_surat', 50)->nullable();
            $table->timestamps();

            $table->index('warga_id');
            $table->index('tgl_pindah');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peristiwa_pindah');
    }
};
