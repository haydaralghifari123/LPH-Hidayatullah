<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiayaClient extends Model
{
    protected $fillable = [
        'no_biaya', 'perusahaan_id', 'tanggal_terbit', 'hok_jumlah_produk',
        'biaya_bpjph', 'biaya_lph', 'biaya_transportasi', 'biaya_uji_lab',
        'total_biaya', 'status',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
