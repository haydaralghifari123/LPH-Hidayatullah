<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PortalAuthController extends Controller
{
    public function showLogin()
    {
        return view('portal.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::guard('client')->attempt(['email' => $data['email'], 'password' => $data['password'], 'is_active' => true], $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'Email atau password tidak sesuai.']);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('portal.dashboard'));
    }

    public function showRegister()
    {
        return view('portal.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_pic' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:clients,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'nama_pelaku_usaha' => ['required', 'string', 'max:150'],
            'merek_dagang' => ['nullable', 'string', 'max:100'],
            'jenis_ajuan' => ['required', 'string', 'max:50'],
            'skala' => ['required', 'in:Mikro,Kecil,Menengah,Besar'],
            'jenis_produk' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string'],
            'kota' => ['nullable', 'string'],
            'provinsi' => ['nullable', 'string'],
            'is_foreign' => ['nullable', 'boolean'],
        ]);

        $client = DB::transaction(function () use ($data) {
            $noRef = 'REF-' . date('Y') . '-' . str_pad((string) (Perusahaan::whereYear('created_at', date('Y'))->count() + 1), 4, '0', STR_PAD_LEFT);
            $perusahaan = Perusahaan::create([
                'no_ref' => $noRef,
                'nama_pelaku_usaha' => $data['nama_pelaku_usaha'],
                'merek_dagang' => $data['merek_dagang'] ?? null,
                'jenis_ajuan' => $data['jenis_ajuan'],
                'skala' => $data['skala'],
                'jenis_produk' => $data['jenis_produk'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'kota' => $data['kota'] ?? null,
                'provinsi' => $data['provinsi'] ?? null,
                'is_foreign' => $data['is_foreign'] ?? false,
                'email' => $data['email'],
                'no_telepon' => $data['no_hp'] ?? null,
                'status' => 'Pengajuan',
            ]);

            return Client::create([
                'perusahaan_id' => $perusahaan->id,
                'email' => $data['email'],
                'password' => $data['password'],
                'nama_pic' => $data['nama_pic'],
                'no_hp' => $data['no_hp'] ?? null,
                'jabatan' => $data['jabatan'] ?? null,
                'is_active' => true,
            ]);
        });

        Auth::guard('client')->login($client);
        return redirect()->route('portal.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('portal.login');
    }
}
