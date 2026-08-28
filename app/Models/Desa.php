<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desa extends Model
{
    protected $table = 'desa';

    protected $fillable = [
        'kecamatan_id',
        'nama_desa',
        'jenis',
    ];

    public static function rules(): array
    {
        return [
            'kecamatan_id' => ['required', 'exists:kecamatan,id'],
            'nama_desa' => ['required', 'string', 'max:255'],
        ];
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }
}
