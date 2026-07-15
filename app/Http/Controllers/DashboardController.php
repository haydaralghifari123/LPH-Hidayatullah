<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use App\Models\Invoice;
use App\Models\Perusahaan;
use App\Models\SertifikatHalal;
use App\Models\SuratTugas;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pengajuan' => Perusahaan::count(),
            'dalam_proses' => Perusahaan::whereIn('status', ['Pengajuan', 'Verifikasi'])->count(),
            'audit_berjalan' => Perusahaan::where('status', 'Audit Berjalan')->count(),
            'selesai' => Perusahaan::where('status', 'Selesai')->count(),
            'total_auditor' => Auditor::count(),
            'auditor_aktif' => Auditor::where('status', 'aktif')->count(),
            'sertifikat_terbit' => SertifikatHalal::where('status', 'Terbit')->count(),
            'surat_tugas' => SuratTugas::count(),
            'total_pendapatan' => Invoice::where('status', 'lunas')->sum('grand_total'),
        ];

        $recent_pengajuan = Perusahaan::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recent_pengajuan'));
    }
}
