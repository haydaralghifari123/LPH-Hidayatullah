<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Penawaran;
use App\Models\Perusahaan;
use App\Models\SuratTugas;
use App\Services\DocxTemplateService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function __construct(private DocxTemplateService $docx)
    {
    }

    public function suratTugas(Request $request, SuratTugas $suratTuga): BinaryFileResponse
    {
        $suratTuga->load(['perusahaan', 'auditor']);

        $values = [
            'Nomer' => $suratTuga->no_surat,
            'No.Ref' => $suratTuga->perusahaan->no_ref ?? '-',
            'Nama Auditor' => $suratTuga->auditor->nama ?? '-',
            'Tgl Audit' => $this->formatTanggal($suratTuga->tanggal_audit, 'id'),
            'Skala Usaha' => $suratTuga->perusahaan->skala ?? '-',
            'Pelaku Usaha' => $suratTuga->perusahaan->nama_pelaku_usaha ?? '-',
            'No Daftar' => $suratTuga->perusahaan->no_ref ?? '-',
            'Lokasi' => $suratTuga->lokasi ?: trim(($suratTuga->perusahaan->kota ?? '') . ', ' . ($suratTuga->perusahaan->provinsi ?? ''), ', '),
            'Tanggal Diterbitkan' => $this->formatTanggal($suratTuga->tanggal_terbit, 'id'),
        ];

        return $this->render($request, 'surat_tugas.docx', $values, "Surat-Tugas-{$suratTuga->no_surat}");
    }

    public function quotation(Request $request, Penawaran $penawaran): BinaryFileResponse
    {
        $penawaran->load('perusahaan');
        $p = $penawaran->perusahaan;
        $currency = $penawaran->mata_uang ?: 'IDR';

        $totalLph = (float) $penawaran->biaya_lph;
        $tta = (float) $penawaran->travel_time_allowance;
        $ttaPerDay = (float) $penawaran->tta_per_day;
        $totalReal = (float) $penawaran->biaya_bpjph + $totalLph + $tta;

        $values = [
            'Tanggal' => $this->formatTanggal($penawaran->tanggal_terbit, 'en'),
            'No' => $penawaran->no_penawaran,
            'Penerima' => $p->nama_pelaku_usaha ?? '-',
            'Jenis Ajuan' => $p->jenis_ajuan ?? '-',
            'Jumlah Produk' => (string) ($p->jumlah_produk ?? 1),
            'Jumlah Pabrik' => (string) ($p->jumlah_pabrik ?? 1),
            'Jumlah Bahan' => (string) ($p->jumlah_bahan ?? 1),
            'Mata Uang' => $currency,
            'Biaya BPJPH' => $this->formatMoney($penawaran->biaya_bpjph, $currency),
            'Total LPH' => $this->formatMoney($totalLph, $currency),
            'TTA' => $this->formatMoney($ttaPerDay, $currency),
            'Travel Time Allowance' => $this->formatMoney($tta, $currency),
            'Total Real' => $this->formatMoney($totalReal, $currency),
            'HOK Pabrik' => $this->formatMoney($penawaran->hok_pabrik, $currency),
            'HOK Bahan' => $this->formatMoney($penawaran->hok_bahan, $currency),
        ];

        return $this->render($request, 'quotation.docx', $values, "Quotation-{$penawaran->no_penawaran}");
    }

    public function statementLetter(Request $request, Perusahaan $perusahaan): BinaryFileResponse
    {
        $values = [
            'NF' => sprintf('SL/%s/LPH-H/%s', str_pad((string) $perusahaan->id, 4, '0', STR_PAD_LEFT), now()->format('Y')),
            'CN' => $perusahaan->nama_pelaku_usaha,
            'BLN' => $perusahaan->business_license_no ?: '-',
            'ADD' => $perusahaan->alamat ?: trim(($perusahaan->kota ?? '') . ', ' . ($perusahaan->provinsi ?? ''), ', '),
            'DT' => $this->formatTanggal(now(), 'en'),
        ];

        return $this->render($request, 'statement_letter.docx', $values, "Statement-Letter-{$perusahaan->no_ref}");
    }

    public function auditReport(Request $request, SuratTugas $suratTuga): BinaryFileResponse
    {
        $suratTuga->load('perusahaan');
        $p = $suratTuga->perusahaan;

        $values = [
            'Letter Number' => sprintf('AR/%s/LPH-H/%s', $suratTuga->id, now()->format('Y')),
            'Company Name' => $p->nama_pelaku_usaha ?? '-',
            'Date' => $this->formatTanggal($suratTuga->tanggal_audit, 'en'),
            'Address' => $p->alamat ?: trim(($p->kota ?? '') . ', ' . ($p->provinsi ?? ''), ', '),
            'Scope' => $suratTuga->scope_audit ?: ($p->jenis_ajuan ?? '-'),
            'Audit Rating' => $suratTuga->audit_rating ?: 'B',
        ];

        return $this->render($request, 'audit_report.docx', $values, "Audit-Report-{$suratTuga->no_surat}");
    }

    public function invoiceDn(Request $request, Invoice $invoice): BinaryFileResponse
    {
        $invoice->load('perusahaan');
        $p = $invoice->perusahaan;

        $skema = $invoice->skema_pembayaran ?? 'Lunas / Sekali Bayar';
        $nominalDp = 0;
        if (stripos($skema, 'DP') !== false) {
            $nominalDp = (float) $invoice->grand_total * 0.5;
        } elseif (stripos($skema, 'Termin') !== false) {
            $nominalDp = (float) $invoice->grand_total / 3;
        }

        $values = [
            'Nama Pelaku Usaha' => $p->nama_pelaku_usaha ?? '-',
            'Nomer Invoice' => $invoice->no_invoice,
            'Tanggal Invoice' => $this->formatTanggal($invoice->tanggal_invoice, 'id'),
            'Nomer Daftar' => $p->no_ref ?? '-',
            'Keterangan' => $invoice->keterangan ?: ('Biaya sertifikasi halal untuk ' . ($p->nama_pelaku_usaha ?? '')),
            'Nominal Invoice' => 'Rp ' . number_format((float) $invoice->total_tagihan, 0, ',', '.'),
            'Skema Pembayaran' => $skema . ($nominalDp > 0 ? ' — DP: Rp ' . number_format($nominalDp, 0, ',', '.') : ''),
            'Nominal DP' => $nominalDp > 0 ? 'Rp ' . number_format($nominalDp, 0, ',', '.') : '-',
            'Total' => 'Rp ' . number_format((float) $invoice->grand_total, 0, ',', '.'),
        ];

        return $this->render($request, 'invoice_dn.docx', $values, "Invoice-{$invoice->no_invoice}");
    }

    public function pembiayaan(Request $request, Penawaran $penawaran): BinaryFileResponse
    {
        $penawaran->load('perusahaan');
        $p = $penawaran->perusahaan;

        $values = [
            'Nomor Surat' => 'PMB/' . str_pad((string) $penawaran->id, 4, '0', STR_PAD_LEFT) . '/LPH-H/' . now()->format('Y'),
            'Tanggal Terbit' => $this->formatTanggal($penawaran->tanggal_terbit, 'id'),
            'Nama Perusahaan' => $p->nama_pelaku_usaha ?? '-',
            'Jumlah HOK' => (string) $penawaran->hok_jumlah_produk,
            'Jenis Ajuan' => $p->jenis_ajuan ?? '-',
            'Skala' => $p->skala ?? '-',
            'BPJPH' => 'Rp ' . number_format((float) $penawaran->biaya_bpjph, 0, ',', '.'),
            'LPH' => 'Rp ' . number_format((float) $penawaran->biaya_lph, 0, ',', '.'),
            'TRANSPORTASI' => 'Rp ' . number_format((float) $penawaran->biaya_transportasi, 0, ',', '.'),
            'UJI LAB' => 'Rp ' . number_format((float) $penawaran->biaya_uji_lab, 0, ',', '.'),
            'TOTAL' => 'Rp ' . number_format((float) $penawaran->total_biaya, 0, ',', '.'),
        ];

        return $this->render($request, 'pembiayaan.docx', $values, "Pembiayaan-{$penawaran->no_penawaran}");
    }

    public function invoiceLn(Request $request, Invoice $invoice): BinaryFileResponse
    {
        $invoice->load('perusahaan');
        $p = $invoice->perusahaan;

        // Ambil rincian biaya dari penawaran terkait bila ada
        $penawaran = Penawaran::where('perusahaan_id', $p?->id)->latest()->first();
        $govFee = $penawaran ? (float) $penawaran->biaya_bpjph : 0;
        $lphFee = $penawaran ? (float) $penawaran->biaya_lph : (float) $invoice->total_tagihan;
        $tta = $penawaran ? (float) $penawaran->travel_time_allowance : 0;
        $total = $govFee + $lphFee + $tta;

        $values = [
            'NamaPUInvoiceLN' => $p->nama_pelaku_usaha ?? '-',
            'NoInvoice' => $invoice->no_invoice,
            'TglInvoiceLN' => $this->formatTanggal($invoice->tanggal_invoice, 'en'),
            'GovFee' => number_format($govFee, 2, '.', ','),
            'LPHfee' => number_format($lphFee, 2, '.', ','),
            'TTA' => number_format($tta, 2, '.', ','),
            'TotalInvoice' => number_format($total, 2, '.', ','),
        ];

        return $this->render($request, 'invoice_ln.docx', $values, "Invoice-LN-{$invoice->no_invoice}");
    }

    /**
     * Render output as DOCX by default (persis template). Pass ?format=pdf untuk PDF via dompdf.
     */
    private function render(Request $request, string $templateName, array $values, string $downloadNameBase): BinaryFileResponse
    {
        $format = strtolower($request->query('format', 'docx'));
        $templatePath = storage_path("app/templates/{$templateName}");

        if ($format === 'pdf') {
            $outputPath = storage_path('app/tmp/' . Str::random(16) . '.pdf');
            if (! is_dir(dirname($outputPath))) {
                mkdir(dirname($outputPath), 0755, true);
            }
            $this->docx->generatePdf($templatePath, $values, $outputPath);
            return response()
                ->download($outputPath, "{$downloadNameBase}.pdf", [
                    'Content-Type' => 'application/pdf',
                ])
                ->deleteFileAfterSend(true);
        }

        // default: DOCX (persis template)
        $outputPath = storage_path('app/tmp/' . Str::random(16) . '.docx');
        if (! is_dir(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }
        $this->docx->generate($templatePath, $values, $outputPath);

        return response()
            ->download($outputPath, "{$downloadNameBase}.pdf", [
                'Content-Type' => 'application/pdf',
            ])
            ->deleteFileAfterSend(true);
    }

    private function formatTanggal(mixed $date, string $lang = 'id'): string
    {
        if (! $date) {
            return '-';
        }
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        if ($lang === 'en') {
            return $carbon->locale('en')->translatedFormat('F j, Y');
        }
        return $carbon->locale('id')->translatedFormat('j F Y');
    }

    private function formatMoney(float $amount, string $currency = 'IDR'): string
    {
        if ($currency === 'IDR') {
            return number_format($amount, 0, ',', '.');
        }
        return number_format($amount, 2, '.', ',');
    }
}
