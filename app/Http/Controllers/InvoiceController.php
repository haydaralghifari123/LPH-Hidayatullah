<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('perusahaan');
        if ($q = $request->input('q')) {
            $query->where('no_invoice', 'like', "%{$q}%");
        }
        $items = $query->latest()->paginate(10)->withQueryString();
        $stats = [
            'total' => Invoice::count(),
            'lunas' => Invoice::where('status', 'lunas')->count(),
            'tertagih' => Invoice::where('status', 'terkirim')->sum('grand_total'),
            'pendapatan' => Invoice::where('status', 'lunas')->sum('grand_total'),
        ];
        return view('invoice.index', compact('items', 'stats'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        $no = 'INV-' . date('Y') . '-' . str_pad((string)(Invoice::whereYear('created_at', date('Y'))->count() + 1), 4, '0', STR_PAD_LEFT);
        return view('invoice.create', compact('perusahaans', 'no'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['no_invoice'] = $data['no_invoice'] ?: ('INV-' . date('Y') . '-' . str_pad((string)(Invoice::whereYear('created_at', date('Y'))->count() + 1), 4, '0', STR_PAD_LEFT));
        $data['grand_total'] = max(0, $data['total_tagihan'] - $data['diskon']);
        Invoice::create($data);
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice disimpan.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('perusahaan');
        return view('invoice.show', ['item' => $invoice]);
    }

    public function edit(Invoice $invoice)
    {
        $perusahaans = Perusahaan::orderBy('nama_pelaku_usaha')->get();
        return view('invoice.edit', ['item' => $invoice, 'perusahaans' => $perusahaans]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $this->validateData($request);
        $data['grand_total'] = max(0, $data['total_tagihan'] - $data['diskon']);
        $invoice->update($data);
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice diperbarui.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoice.index')->with('success', 'Dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'no_invoice' => ['nullable', 'string', 'max:30'],
            'perusahaan_id' => ['required', 'exists:perusahaans,id'],
            'tanggal_invoice' => ['required', 'date'],
            'hok_jumlah_produk' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string'],
            'total_tagihan' => ['required', 'numeric', 'min:0'],
            'diskon' => ['required', 'numeric', 'min:0'],
            'skema_pembayaran' => ['required', 'string'],
            'status' => ['required', 'in:draft,terkirim,lunas'],
        ]);
    }
}
