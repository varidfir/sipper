<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPelayanan extends Model
{
    protected $table = 'jenis_pelayanan';

    protected $fillable = [
        'kelompok_pelayanan_id',
        'kode',
        'nama_pelayanan',
        'kategori',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public static function rules(): array
    {
        return [
            'kelompok_pelayanan_id' => ['required', 'exists:kelompok_pelayanan,id'],
            'kode' => ['nullable', 'string', 'max:50'],
            'nama_pelayanan' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ];
    }

    public function kelompokPelayanan(): BelongsTo
    {
        return $this->belongsTo(KelompokPelayanan::class, 'kelompok_pelayanan_id');
    }

    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'jenis_pelayanan_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }
}
