<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PenawaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Penawaran::with('perusahaan');
        if ($q = $request->input('q')) {
            $query->where('no_penawaran', 'like', "%{$q}%");
        }
        $items = $query->latest()->paginate(10)->withQueryString();
        return view('penawaran.index', compact('items'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        $no = 'PNW-' . date('Y') . '-' . str_pad((string)(Penawaran::whereYear('created_at', date('Y'))->count() + 1), 4, '0', STR_PAD_LEFT);
        return view('penawaran.create', compact('perusahaans', 'no'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['no_penawaran'] = $data['no_penawaran'] ?: ('PNW-' . date('Y') . '-' . str_pad((string)(Penawaran::whereYear('created_at', date('Y'))->count() + 1), 4, '0', STR_PAD_LEFT));
        $data['total_biaya'] = $data['biaya_bpjph'] + $data['biaya_lph'] + $data['biaya_transportasi'] + $data['biaya_uji_lab'];
        Penawaran::create($data);
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran disimpan.');
    }

    public function show(Penawaran $penawaran)
    {
        $penawaran->load('perusahaan');
        return view('penawaran.show', ['item' => $penawaran]);
    }

    public function edit(Penawaran $penawaran)
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        return view('penawaran.edit', ['item' => $penawaran, 'perusahaans' => $perusahaans]);
    }

    public function update(Request $request, Penawaran $penawaran)
    {
        $data = $this->validateData($request);
        $data['total_biaya'] = $data['biaya_bpjph'] + $data['biaya_lph'] + $data['biaya_transportasi'] + $data['biaya_uji_lab'];
        $penawaran->update($data);
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran diperbarui.');
    }

    public function destroy(Penawaran $penawaran)
    {
        $penawaran->delete();
        return redirect()->route('admin.penawaran.index')->with('success', 'Dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'no_penawaran' => ['nullable', 'string', 'max:30'],
            'perusahaan_id' => ['required', 'exists:perusahaans,id'],
            'mata_uang' => ['nullable', 'string', 'max:5'],
            'tanggal_terbit' => ['required', 'date'],
            'hok_jumlah_produk' => ['required', 'integer', 'min:1'],
            'biaya_bpjph' => ['required', 'numeric', 'min:0'],
            'biaya_lph' => ['required', 'numeric', 'min:0'],
            'biaya_transportasi' => ['required', 'numeric', 'min:0'],
            'biaya_uji_lab' => ['required', 'numeric', 'min:0'],
            'travel_time_allowance' => ['nullable', 'numeric', 'min:0'],
            'tta_per_day' => ['nullable', 'numeric', 'min:0'],
            'hok_pabrik' => ['nullable', 'numeric', 'min:0'],
            'hok_bahan' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,terkirim,disetujui'],
        ]);
    }
}
