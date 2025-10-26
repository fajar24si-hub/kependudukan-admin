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
        Schema::create('peristiwa_pindah', function (Blueprint $table) {
            $table->id('pindah_id');
            $table->foreignId('warga_id');
            $table->date('tgl_pindah');
            $table->text('alamat_tujuan');
            $table->string('alasan');
            $table->string('no_surat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peristiwa_pindah');
    }
};
