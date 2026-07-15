<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalProfilController extends Controller
{
    public function edit()
    {
        $client = Auth::guard('client')->user();
        $perusahaan = $client->perusahaan;
        return view('portal.profil', compact('client', 'perusahaan'));
    }

    public function update(Request $request)
    {
        $client = Auth::guard('client')->user();
        $perusahaan = $client->perusahaan;

        $data = $request->validate([
            'nama_pic' => ['required', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'nama_pelaku_usaha' => ['required', 'string', 'max:150'],
            'merek_dagang' => ['nullable', 'string', 'max:100'],
            'business_license_no' => ['nullable', 'string'],
            'nib' => ['nullable', 'string'],
            'npwp' => ['nullable', 'string'],
            'no_sihalal' => ['nullable', 'string'],
            'jenis_ajuan' => ['required', 'string'],
            'jenis_produk' => ['nullable', 'string'],
            'skala' => ['required', 'in:Mikro,Kecil,Menengah,Besar'],
            'alamat' => ['nullable', 'string'],
            'kota' => ['nullable', 'string'],
            'provinsi' => ['nullable', 'string'],
        ]);

        $client->update([
            'nama_pic' => $data['nama_pic'],
            'no_hp' => $data['no_hp'] ?? null,
            'jabatan' => $data['jabatan'] ?? null,
        ]);

        if ($perusahaan) {
            $perusahaan->update([
                'nama_pelaku_usaha' => $data['nama_pelaku_usaha'],
                'merek_dagang' => $data['merek_dagang'] ?? null,
                'business_license_no' => $data['business_license_no'] ?? null,
                'nib' => $data['nib'] ?? null,
                'npwp' => $data['npwp'] ?? null,
                'no_sihalal' => $data['no_sihalal'] ?? null,
                'jenis_ajuan' => $data['jenis_ajuan'],
                'jenis_produk' => $data['jenis_produk'] ?? null,
                'skala' => $data['skala'],
                'alamat' => $data['alamat'] ?? null,
                'kota' => $data['kota'] ?? null,
                'provinsi' => $data['provinsi'] ?? null,
            ]);
        }

        return redirect()->route('portal.profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
