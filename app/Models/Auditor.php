<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auditor extends Model
{
    protected $fillable = [
        'no_registrasi', 'nama', 'alamat', 'email', 'no_telepon',
        'pendidikan_s1', 'pendidikan_s2', 'pendidikan_s3',
        'kompetensi', 'status', 'beban_kerja', 'lokasi_kota',
    ];

    public function suratTugas(): HasMany
    {
        return $this->hasMany(SuratTugas::class);
    }
}
