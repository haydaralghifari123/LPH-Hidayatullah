<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SertifikatHalal extends Model
{
    protected $fillable = [
        'no_sertifikat', 'perusahaan_id', 'jenis_daftar', 'jenis_produk',
        'merek_dagang', 'tanggal_terbit', 'tanggal_expired', 'status', 'file_pdf',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_expired' => 'date',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
