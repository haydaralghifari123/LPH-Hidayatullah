<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use Illuminate\Support\Facades\Auth;

class PortalPenawaranController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $penawarans = Penawaran::where('perusahaan_id', $client->perusahaan_id)
            ->latest()->get();
        return view('portal.penawaran', compact('client', 'penawarans'));
    }

    public function approve(Penawaran $penawaran)
    {
        $client = Auth::guard('client')->user();
        if ($penawaran->perusahaan_id !== $client->perusahaan_id) {
            abort(403);
        }
        $penawaran->update([
            'status' => 'disetujui',
            'disetujui_klien_at' => now(),
        ]);
        return back()->with('success', 'Penawaran disetujui. Menunggu invoice dari LPH.');
    }
}
