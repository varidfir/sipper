<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $fillable = [
        'nama_kecamatan',
    ];

    public static function rules(): array
    {
        return [
            'nama_kecamatan' => ['required', 'string', 'max:255', 'unique:kecamatan,nama_kecamatan'],
        ];
    }

    public function desas(): HasMany
    {
        return $this->hasMany(Desa::class);
    }

    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }
}
