<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratTugas extends Model
{
    protected $table = 'surat_tugas';

    protected $fillable = [
        'no_surat', 'perusahaan_id', 'auditor_id', 'tanggal_terbit',
        'tanggal_audit', 'lokasi', 'catatan', 'status_kirim',
        'scope_audit', 'audit_rating', 'hasil_audit',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_audit' => 'date',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function auditor(): BelongsTo
    {
        return $this->belongsTo(Auditor::class);
    }
}
