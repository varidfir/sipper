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
        if (!Schema::hasColumn('desa', 'jenis')) {
            Schema::table('desa', function (Blueprint $table) {
                $table->enum('jenis', ['desa', 'kelurahan'])->default('desa')->after('nama_desa');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('desa', 'jenis')) {
            Schema::table('desa', function (Blueprint $table) {
                $table->dropColumn('jenis');
            });
        }
    }
};
