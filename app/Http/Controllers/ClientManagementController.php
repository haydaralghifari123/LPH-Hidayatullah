<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with('perusahaan');
        if ($q = $request->input('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_pic', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhereHas('perusahaan', fn($p) => $p->where('nama_pelaku_usaha', 'like', "%{$q}%"));
            });
        }
        if ($status = $request->input('status')) {
            $query->where('is_active', $status === 'aktif');
        }
        $clients = $query->latest()->paginate(15)->withQueryString();
        $stats = [
            'total' => Client::count(),
            'aktif' => Client::where('is_active', true)->count(),
            'nonaktif' => Client::where('is_active', false)->count(),
            'perusahaan_terhubung' => Client::whereNotNull('perusahaan_id')->distinct('perusahaan_id')->count('perusahaan_id'),
        ];
        return view('client_management.index', compact('clients', 'stats'));
    }

    public function show(Client $client)
    {
        $client->load(['perusahaan.suratTugas.auditor', 'perusahaan.penawarans', 'perusahaan.invoices', 'perusahaan.sertifikat', 'documents']);
        return view('client_management.show', compact('client'));
    }

    public function toggleActive(Client $client)
    {
        $client->update(['is_active' => ! $client->is_active]);
        $status = $client->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$client->nama_pic} berhasil {$status}.");
    }

    public function resetPassword(Client $client)
    {
        $newPassword = Str::random(10);
        $client->update(['password' => Hash::make($newPassword)]);
        return back()->with('success', "Password {$client->nama_pic} direset menjadi: {$newPassword} — segera salin & kirim ke klien.");
    }

    public function destroy(Client $client)
    {
        $nama = $client->nama_pic;
        $client->delete();
        return redirect()->route('admin.klien.index')->with('success', "Akun klien {$nama} dihapus.");
    }
}
