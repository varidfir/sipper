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
        Schema::create('jenis_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelayanan', 255);
            $table->string('kategori', 255); // Misalnya: Kartu Keluarga (KK), KTP Elektronik, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pelayanan');
    }
};
