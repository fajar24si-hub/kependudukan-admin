// database/migrations/[timestamp]_create_media_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');
            $table->string('ref_table'); // 'peristiwa_kelahiran', 'peristiwa_kematian', 'peristiwa_pindah'
            $table->unsignedBigInteger('ref_id'); // ID dari tabel referensi
            $table->string('file_name');
            $table->string('caption')->nullable();
            $table->string('mime_type');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index(['ref_table', 'ref_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('media');
    }
};
