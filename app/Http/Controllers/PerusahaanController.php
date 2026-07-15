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
