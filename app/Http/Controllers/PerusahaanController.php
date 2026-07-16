<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perusahaan::query()->with(['suratTugas.auditor', 'clients']);
        if ($q = $request->input('q')) {
            $query->where('nama_pelaku_usaha', 'like', "%{$q}%")
                ->orWhere('no_ref', 'like', "%{$q}%")
                ->orWhere('merek_dagang', 'like', "%{$q}%");
        }
        $perusahaans = $query->latest()->paginate(10)->withQueryString();
        $stats = [
            'total' => Perusahaan::count(),
            'proses' => Perusahaan::whereIn('status', ['Pengajuan', 'Verifikasi'])->count(),
            'audit_berjalan' => Perusahaan::where('status', 'Audit Berjalan')->count(),
            'selesai' => Perusahaan::where('status', 'Selesai')->count(),
        ];
        return view('perusahaan.index', compact('perusahaans', 'stats'));
    }

    public function create()
    {
        return view('perusahaan.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['no_ref'] = $data['no_ref'] ?: $this->generateNoRef();
        Perusahaan::create($data);
        return redirect()->route('admin.perusahaan.index')->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function show(Perusahaan $perusahaan)
    {
        $perusahaan->load(['penawarans', 'suratTugas.auditor', 'sertifikat', 'invoices', 'clients', 'documents']);
        return view('perusahaan.show', compact('perusahaan'));
    }

    public function edit(Perusahaan $perusahaan)
    {
        return view('perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, Perusahaan $perusahaan)
    {
        $perusahaan->update($this->validateData($request));
        return redirect()->route('admin.perusahaan.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Perusahaan $perusahaan)
    {
        $perusahaan->delete();
        return redirect()->route('admin.perusahaan.index')->with('success', 'Dihapus.');
    }

    /**
     * API endpoint untuk auto-fill form. Return JSON info perusahaan + penawaran terbaru.
     */
    public function apiInfo(Perusahaan $perusahaan)
    {
        $latest = $perusahaan->penawarans()->latest()->first();
        return response()->json([
            'perusahaan' => [
                'nama_pelaku_usaha' => $perusahaan->nama_pelaku_usaha,
                'no_ref' => $perusahaan->no_ref,
                'merek_dagang' => $perusahaan->merek_dagang,
                'jenis_ajuan' => $perusahaan->jenis_ajuan,
                'skala' => $perusahaan->skala,
                'jenis_produk' => $perusahaan->jenis_produk,
                'alamat' => $perusahaan->alamat,
                'kota' => $perusahaan->kota,
                'provinsi' => $perusahaan->provinsi,
                'is_foreign' => (bool) $perusahaan->is_foreign,
                'jumlah_produk' => $perusahaan->jumlah_produk,
                'jumlah_pabrik' => $perusahaan->jumlah_pabrik,
                'jumlah_bahan' => $perusahaan->jumlah_bahan,
                'lokasi_full' => trim(($perusahaan->alamat ?? '') . ($perusahaan->alamat ? ', ' : '') . ($perusahaan->kota ?? '') . ', ' . ($perusahaan->provinsi ?? ''), ', '),
            ],
            'latest_penawaran' => $latest ? [
                'no_penawaran' => $latest->no_penawaran,
                'hok_jumlah_produk' => $latest->hok_jumlah_produk,
                'biaya_bpjph' => (float) $latest->biaya_bpjph,
                'biaya_lph' => (float) $latest->biaya_lph,
                'biaya_transportasi' => (float) $latest->biaya_transportasi,
                'biaya_uji_lab' => (float) $latest->biaya_uji_lab,
                'total_biaya' => (float) $latest->total_biaya,
                'mata_uang' => $latest->mata_uang,
            ] : null,
        ]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'no_ref' => ['nullable', 'string', 'max:30'],
            'nama_pelaku_usaha' => ['required', 'string', 'max:150'],
            'merek_dagang' => ['nullable', 'string', 'max:100'],
            'business_license_no' => ['nullable', 'string', 'max:60'],
            'jenis_ajuan' => ['required', 'string', 'max:50'],
            'skala' => ['required', 'in:Mikro,Kecil,Menengah,Besar'],
            'jenis_produk' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string'],
            'provinsi' => ['nullable', 'string'],
            'kota' => ['nullable', 'string'],
            'is_foreign' => ['nullable', 'boolean'],
            'jumlah_produk' => ['nullable', 'integer', 'min:1'],
            'jumlah_pabrik' => ['nullable', 'integer', 'min:1'],
            'jumlah_bahan' => ['nullable', 'integer', 'min:1'],
            'email' => ['nullable', 'email'],
            'no_telepon' => ['nullable', 'string'],
            'status' => ['required', 'in:Pengajuan,Verifikasi,Audit Berjalan,Selesai,Ditolak'],
        ]);
    }

    private function generateNoRef(): string
    {
        $year = date('Y');
        $count = Perusahaan::whereYear('created_at', $year)->count() + 1;
        return 'REF-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}
