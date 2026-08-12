<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('permohonan', 'nik_pemohon')) {
            Schema::table('permohonan', function (Blueprint $table) {
                $table->dropColumn('nik_pemohon');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('permohonan', 'nik_pemohon')) {
            Schema::table('permohonan', function (Blueprint $table) {
                $table->string('nik_pemohon', 16)->nullable()->after('nama_pemohon');
            });
        }
    }
};
