<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya buat tabel jika belum ada
        if (!Schema::hasTable('peristiwa_kelahiran')) {
            Schema::create('peristiwa_kelahiran', function (Blueprint $table) {
                $table->id('kelahiran_id');
                $table->string('no_akta', 100)->unique();
                $table->date('tgl_lahir');
                $table->string('tempat_lahir', 200);
                $table->unsignedBigInteger('warga_id')->nullable()->comment('ID bayi yang lahir');
                $table->unsignedBigInteger('ayah_warga_id')->nullable()->comment('ID ayah');
                $table->unsignedBigInteger('ibu_warga_id')->nullable()->comment('ID ibu');
                $table->timestamps();

                $table->index('no_akta');
                $table->index('tgl_lahir');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('peristiwa_kelahiran');
    }
};
