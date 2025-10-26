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
        Schema::create('peristiwa_kelahiran', function (Blueprint $table) {
            $table->id('kelahiran_id');
            $table->foreignId('warga_id');
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->foreignId('ayah_warga_id');
            $table->foreignId('ibu_warga_id');
            $table->string('no_akta')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peristiwa_kelahiran');
    }
};
