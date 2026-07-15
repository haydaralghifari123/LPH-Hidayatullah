<?php

namespace App\Http\Controllers;

use App\Models\ClientDocument;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class DocumentVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = ClientDocument::with(['perusahaan', 'client'])->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($pid = $request->input('perusahaan_id')) {
            $query->where('perusahaan_id', $pid);
        }
        if ($q = $request->input('q')) {
            $query->whereHas('perusahaan', fn ($qq) => $qq->where('nama_pelaku_usaha', 'like', "%{$q}%"));
        }

        $documents = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => ClientDocument::count(),
            'pending' => ClientDocument::where('status', 'pending')->count(),
            'approved' => ClientDocument::where('status', 'approved')->count(),
            'rejected' => ClientDocument::where('status', 'rejected')->count(),
        ];

        $perusahaans = Perusahaan::whereHas('documents')->orderBy('nama_pelaku_usaha')->get();

        return view('verifikasi_dokumen.index', compact('documents', 'stats', 'perusahaans'));
    }

    public function show(ClientDocument $document)
    {
        $document->load(['perusahaan', 'client']);
        // Semua dokumen dari perusahaan yang sama
        $sibling = ClientDocument::where('perusahaan_id', $document->perusahaan_id)
            ->where('id', '!=', $document->id)
            ->latest()
            ->get();
        return view('verifikasi_dokumen.show', compact('document', 'sibling'));
    }

    public function approve(Request $request, ClientDocument $document)
    {
        $data = $request->validate([
            'catatan_staf' => ['nullable', 'string', 'max:500'],
        ]);
        $document->update([
            'status' => 'approved',
            'catatan_staf' => $data['catatan_staf'] ?? null,
        ]);
        // Otomatis update status perusahaan ke 'Verifikasi' jika minimal 1 dokumen approved
        if ($document->perusahaan && $document->perusahaan->status === 'Pengajuan') {
            $document->perusahaan->update(['status' => 'Verifikasi']);
        }
        return back()->with('success', 'Dokumen disetujui.');
    }

    public function reject(Request $request, ClientDocument $document)
    {
        $data = $request->validate([
            'catatan_staf' => ['required', 'string', 'min:5', 'max:500'],
        ]);
        $document->update([
            'status' => 'rejected',
            'catatan_staf' => $data['catatan_staf'],
        ]);
        return back()->with('success', 'Dokumen ditolak. Klien diminta upload ulang.');
    }

    public function resetStatus(ClientDocument $document)
    {
        $document->update(['status' => 'pending', 'catatan_staf' => null]);
        return back()->with('success', 'Status direset ke pending.');
    }
}
