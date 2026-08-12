<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokPelayanan extends Model
{
    protected $table = 'kelompok_pelayanan';

    protected $fillable = [
        'kode',
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function jenisPelayanans(): HasMany
    {
        return $this->hasMany(JenisPelayanan::class, 'kelompok_pelayanan_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }
}
