<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use App\Models\Perusahaan;
use App\Models\SuratTugas;
use Illuminate\Http\Request;

class PemilihanAuditorController extends Controller
{
    public function index(Request $request)
    {
        $perusahaans = Perusahaan::whereIn('status', ['Pengajuan', 'Verifikasi'])->orderBy('nama_pelaku_usaha')->get();
        $selected = null;
        $recommendations = collect();

        if ($pid = $request->input('perusahaan_id')) {
            $selected = Perusahaan::find($pid);
            if ($selected) {
                $recommendations = Auditor::where('status', 'aktif')
                    ->get()
                    ->map(function ($a) use ($selected) {
                        $jarak = strcasecmp($a->lokasi_kota ?? '', $selected->kota ?? '') === 0 ? 1 : ($a->lokasi_kota ? 50 : 100);
                        $score = 100 - ($jarak * 0.5) - ($a->beban_kerja * 10);
                        $a->jarak_estimasi = $jarak;
                        $a->skor = max(0, round($score, 1));
                        return $a;
                    })
                    ->sortByDesc('skor')
                    ->take(5)
                    ->values();
            }
        }

        return view('pemilihan_auditor.index', compact('perusahaans', 'selected', 'recommendations'));
    }

    public function assign(Request $request)
    {
        $data = $request->validate([
            'perusahaan_id' => ['required', 'exists:perusahaans,id'],
            'auditor_id' => ['required', 'exists:auditors,id'],
            'tanggal_audit' => ['required', 'date'],
        ]);

        $perusahaan = Perusahaan::findOrFail($data['perusahaan_id']);
        $no = 'ST-' . date('Y') . '-' . str_pad((string)(SuratTugas::whereYear('created_at', date('Y'))->count() + 1), 4, '0', STR_PAD_LEFT);

        SuratTugas::create([
            'no_surat' => $no,
            'perusahaan_id' => $data['perusahaan_id'],
            'auditor_id' => $data['auditor_id'],
            'tanggal_terbit' => now(),
            'tanggal_audit' => $data['tanggal_audit'],
            'lokasi' => trim(($perusahaan->kota ?? '') . ', ' . ($perusahaan->provinsi ?? ''), ', '),
            'status_kirim' => 'belum',
        ]);

        Auditor::where('id', $data['auditor_id'])->increment('beban_kerja');
        $perusahaan->update(['status' => 'Audit Berjalan']);

        return redirect()->route('admin.surat-tugas.index')->with('success', 'Auditor berhasil ditugaskan & surat tugas dibuat.');
    }
}
