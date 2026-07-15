<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\SertifikatHalal;
use Illuminate\Http\Request;

class SertifikatHalalController extends Controller
{
    public function index(Request $request)
    {
        $query = SertifikatHalal::with('perusahaan');
        if ($q = $request->input('q')) {
            $query->where('no_sertifikat', 'like', "%{$q}%")
                ->orWhereHas('perusahaan', fn($qq) => $qq->where('nama_pelaku_usaha', 'like', "%{$q}%"));
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        $items = $query->latest()->paginate(10)->withQueryString();
        $stats = [
            'total' => SertifikatHalal::count(),
            'menunggu' => SertifikatHalal::where('status', 'Menunggu')->count(),
            'bulan_ini' => SertifikatHalal::whereMonth('tanggal_terbit', now()->month)->count(),
            'akan_expired' => SertifikatHalal::whereBetween('tanggal_expired', [now(), now()->addMonths(3)])->count(),
        ];
        return view('sertifikat.index', compact('items', 'stats'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::where('status', 'Selesai')->orWhere('status', 'Audit Berjalan')->orderBy('nama_pelaku_usaha')->get();
        return view('sertifikat.create', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')->store('sertifikat', 'public');
        }
        $data['no_sertifikat'] = $data['no_sertifikat'] ?: $this->generateNoSertifikat();
        SertifikatHalal::create($data);
        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil diterbitkan.');
    }

    public function show(SertifikatHalal $sertifikat)
    {
        $sertifikat->load('perusahaan');
        return view('sertifikat.show', ['item' => $sertifikat]);
    }

    public function edit(SertifikatHalal $sertifikat)
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        return view('sertifikat.edit', ['item' => $sertifikat, 'perusahaans' => $perusahaans]);
    }

    public function update(Request $request, SertifikatHalal $sertifikat)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')->store('sertifikat', 'public');
        }
        $sertifikat->update($data);
        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat diperbarui.');
    }

    public function destroy(SertifikatHalal $sertifikat)
    {
        $sertifikat->delete();
        return redirect()->route('admin.sertifikat.index')->with('success', 'Dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'no_sertifikat' => ['nullable', 'string', 'max:30'],
            'perusahaan_id' => ['required', 'exists:perusahaans,id'],
            'jenis_daftar' => ['required', 'string'],
            'jenis_produk' => ['nullable', 'string'],
            'merek_dagang' => ['nullable', 'string'],
            'tanggal_terbit' => ['required', 'date'],
            'tanggal_expired' => ['nullable', 'date'],
            'status' => ['required', 'in:Menunggu,Terbit,Expired'],
            'file_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);
    }

    private function generateNoSertifikat(): string
    {
        $year = date('Y');
        $count = SertifikatHalal::whereYear('created_at', $year)->count() + 1;
        return 'LPH-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}
