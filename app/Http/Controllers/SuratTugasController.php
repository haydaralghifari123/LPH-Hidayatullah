<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use App\Models\Perusahaan;
use App\Models\SuratTugas;
use Illuminate\Http\Request;

class SuratTugasController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratTugas::with(['perusahaan', 'auditor']);
        if ($q = $request->input('q')) {
            $query->where('no_surat', 'like', "%{$q}%")
                ->orWhereHas('perusahaan', fn($qq) => $qq->where('nama_pelaku_usaha', 'like', "%{$q}%"));
        }
        $items = $query->latest()->paginate(10)->withQueryString();
        $stats = [
            'total' => SuratTugas::count(),
            'belum' => SuratTugas::where('status_kirim', 'belum')->count(),
            'terkirim' => SuratTugas::where('status_kirim', 'terkirim')->count(),
            'pekan_ini' => SuratTugas::whereBetween('tanggal_audit', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
        return view('surat_tugas.index', compact('items', 'stats'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        $auditors = Auditor::where('status', 'aktif')->orderBy('nama')->get();
        return view('surat_tugas.create', compact('perusahaans', 'auditors'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['no_surat'] = $data['no_surat'] ?: $this->generateNoSurat();
        SuratTugas::create($data);
        Auditor::where('id', $data['auditor_id'])->increment('beban_kerja');
        return redirect()->route('admin.surat-tugas.index')->with('success', 'Surat tugas dibuat.');
    }

    public function show(SuratTugas $suratTuga)
    {
        $suratTuga->load(['perusahaan', 'auditor']);
        return view('surat_tugas.show', ['item' => $suratTuga]);
    }

    public function edit(SuratTugas $suratTuga)
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        $auditors = Auditor::orderBy('nama')->get();
        return view('surat_tugas.edit', ['item' => $suratTuga, 'perusahaans' => $perusahaans, 'auditors' => $auditors]);
    }

    public function update(Request $request, SuratTugas $suratTuga)
    {
        $suratTuga->update($this->validateData($request));
        return redirect()->route('admin.surat-tugas.index')->with('success', 'Surat tugas diperbarui.');
    }

    public function destroy(SuratTugas $suratTuga)
    {
        $suratTuga->delete();
        return redirect()->route('admin.surat-tugas.index')->with('success', 'Dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'no_surat' => ['nullable', 'string', 'max:30'],
            'perusahaan_id' => ['required', 'exists:perusahaans,id'],
            'auditor_id' => ['required', 'exists:auditors,id'],
            'tanggal_terbit' => ['required', 'date'],
            'tanggal_audit' => ['required', 'date'],
            'lokasi' => ['nullable', 'string'],
            'scope_audit' => ['nullable', 'string'],
            'audit_rating' => ['nullable', 'in:A,B,C,D'],
            'catatan' => ['nullable', 'string'],
            'status_kirim' => ['required', 'in:belum,terkirim'],
        ]);
    }

    private function generateNoSurat(): string
    {
        $year = date('Y');
        $count = SuratTugas::whereYear('created_at', $year)->count() + 1;
        return 'ST-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}
