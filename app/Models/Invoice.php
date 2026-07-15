<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'no_invoice', 'perusahaan_id', 'tanggal_invoice', 'hok_jumlah_produk',
        'keterangan', 'total_tagihan', 'diskon', 'grand_total',
        'skema_pembayaran', 'status',
    ];

    protected $casts = [
        'tanggal_invoice' => 'date',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
