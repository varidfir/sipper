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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_permohonan', 50)->unique();
            $table->string('nama_pemohon', 255);
            $table->string('nik_pemohon', 16)->nullable();
            $table->date('tanggal_permohonan');
            $table->foreignId('jenis_pelayanan_id')->constrained('jenis_pelayanan')->onDelete('cascade');
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->onDelete('cascade');
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Petugas yang input
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};
