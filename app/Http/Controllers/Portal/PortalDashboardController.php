<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PortalDashboardController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $perusahaan = $client->perusahaan;
        if ($perusahaan) {
            $perusahaan->load(['penawarans', 'invoices', 'suratTugas.auditor', 'sertifikat']);
        }

        $steps = $this->calculateProgress($perusahaan);

        return view('portal.dashboard', compact('client', 'perusahaan', 'steps'));
    }

    private function calculateProgress($perusahaan): array
    {
        $steps = [
            ['label' => 'Registrasi', 'done' => (bool) $perusahaan],
            ['label' => 'Verifikasi Dokumen', 'done' => false],
            ['label' => 'Penawaran Biaya', 'done' => false],
            ['label' => 'Pembayaran Diterima', 'done' => false],
            ['label' => 'Audit Dijadwalkan', 'done' => false],
            ['label' => 'Audit Selesai', 'done' => false],
            ['label' => 'Sertifikat Terbit', 'done' => false],
        ];

        if (! $perusahaan) {
            return $steps;
        }

        // Docs: at least 1 approved
        $steps[1]['done'] = $perusahaan->documents()->where('status', 'approved')->exists() ?? false;
        // Penawaran ada
        $steps[2]['done'] = $perusahaan->penawarans->isNotEmpty();
        // Invoice lunas
        $steps[3]['done'] = $perusahaan->invoices->where('status', 'lunas')->isNotEmpty();
        // Ada surat tugas
        $steps[4]['done'] = $perusahaan->suratTugas->isNotEmpty();
        // Audit selesai = rating diisi
        $steps[5]['done'] = $perusahaan->suratTugas->whereNotNull('audit_rating')->isNotEmpty();
        // Sertifikat
        $steps[6]['done'] = (bool) $perusahaan->sertifikat;

        return $steps;
    }
}
