<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penawaran extends Model
{
    protected $fillable = [
        'no_penawaran', 'perusahaan_id', 'mata_uang', 'tanggal_terbit', 'hok_jumlah_produk',
        'biaya_bpjph', 'biaya_lph', 'biaya_transportasi', 'biaya_uji_lab',
        'travel_time_allowance', 'tta_per_day', 'hok_pabrik', 'hok_bahan',
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
