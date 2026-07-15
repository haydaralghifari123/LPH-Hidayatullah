<?php

namespace App\Http\Controllers;

use App\Models\BiayaClient;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class BiayaClientController extends Controller
{
    public function index(Request $request)
    {
        $query = BiayaClient::with('perusahaan');
        if ($q = $request->input('q')) {
            $query->where('no_biaya', 'like', "%{$q}%");
        }
        $items = $query->latest()->paginate(10)->withQueryString();
        return view('biaya_client.index', compact('items'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        $no = 'BC-' . date('Y') . '-' . str_pad((string)(BiayaClient::whereYear('created_at', date('Y'))->count() + 1), 4, '0', STR_PAD_LEFT);
        return view('biaya_client.create', compact('perusahaans', 'no'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['no_biaya'] = $data['no_biaya'] ?: ('BC-' . date('Y') . '-' . str_pad((string)(BiayaClient::whereYear('created_at', date('Y'))->count() + 1), 4, '0', STR_PAD_LEFT));
        $data['total_biaya'] = $data['biaya_bpjph'] + $data['biaya_lph'] + $data['biaya_transportasi'] + $data['biaya_uji_lab'];
        BiayaClient::create($data);
        return redirect()->route('admin.biaya-client.index')->with('success', 'Biaya client disimpan.');
    }

    public function show(BiayaClient $biayaClient)
    {
        $biayaClient->load('perusahaan');
        return view('biaya_client.show', ['item' => $biayaClient]);
    }

    public function edit(BiayaClient $biayaClient)
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        return view('biaya_client.edit', ['item' => $biayaClient, 'perusahaans' => $perusahaans]);
    }

    public function update(Request $request, BiayaClient $biayaClient)
    {
        $data = $this->validateData($request);
        $data['total_biaya'] = $data['biaya_bpjph'] + $data['biaya_lph'] + $data['biaya_transportasi'] + $data['biaya_uji_lab'];
        $biayaClient->update($data);
        return redirect()->route('admin.biaya-client.index')->with('success', 'Diperbarui.');
    }

    public function destroy(BiayaClient $biayaClient)
    {
        $biayaClient->delete();
        return redirect()->route('admin.biaya-client.index')->with('success', 'Dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'no_biaya' => ['nullable', 'string', 'max:30'],
            'perusahaan_id' => ['required', 'exists:perusahaans,id'],
            'tanggal_terbit' => ['required', 'date'],
            'hok_jumlah_produk' => ['required', 'integer', 'min:1'],
            'biaya_bpjph' => ['required', 'numeric', 'min:0'],
            'biaya_lph' => ['required', 'numeric', 'min:0'],
            'biaya_transportasi' => ['required', 'numeric', 'min:0'],
            'biaya_uji_lab' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,final'],
        ]);
    }
}
