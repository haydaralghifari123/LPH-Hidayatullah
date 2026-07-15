<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Perusahaan extends Model
{
    protected $fillable = [
        'no_ref', 'nama_pelaku_usaha', 'merek_dagang', 'business_license_no',
        'jenis_ajuan', 'skala', 'jenis_produk', 'alamat', 'provinsi', 'kota',
        'is_foreign', 'jumlah_produk', 'jumlah_pabrik', 'jumlah_bahan',
        'email', 'no_telepon', 'status',
    ];

    protected $casts = [
        'is_foreign' => 'boolean',
    ];

    public function penawarans(): HasMany
    {
        return $this->hasMany(Penawaran::class);
    }

    public function biayaClients(): HasMany
    {
        return $this->hasMany(BiayaClient::class);
    }

    public function suratTugas(): HasMany
    {
        return $this->hasMany(SuratTugas::class);
    }

    public function sertifikat(): HasOne
    {
        return $this->hasOne(SertifikatHalal::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ClientDocument::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
