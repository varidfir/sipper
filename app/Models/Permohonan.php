<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permohonan extends Model
{
    protected $table = 'permohonan';

    protected $fillable = [
        'nomor_permohonan',
        'nama_pemohon',
        'tanggal_permohonan',
        'jenis_pelayanan_id',
        'kecamatan_id',
        'desa_id',
        'user_id',
        'keterangan',
        'detail_data',
    ];

    public static function rules(?int $id = null): array
    {
        return [
            'nama_pemohon' => ['required', 'string', 'max:255'],
            'tanggal_permohonan' => ['required', 'date'],
            'jenis_pelayanan_id' => ['required', 'exists:jenis_pelayanan,id'],
            'kecamatan_id' => ['required', 'exists:kecamatan,id'],
            'desa_id' => ['required', 'exists:desa,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'detail_data' => ['nullable', 'array'],
        ];
    }

    protected $casts = [
        'tanggal_permohonan' => 'date',
        'detail_data' => 'array',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function kecamatan(): BelongsTo { return $this->belongsTo(Kecamatan::class); }
    public function desa(): BelongsTo { return $this->belongsTo(Desa::class); }
    public function jenisPelayanan(): BelongsTo { return $this->belongsTo(JenisPelayanan::class, 'jenis_pelayanan_id'); }
}
