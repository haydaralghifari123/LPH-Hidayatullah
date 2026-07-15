<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalInvoiceController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $invoices = Invoice::where('perusahaan_id', $client->perusahaan_id)
            ->latest()->get();
        return view('portal.invoice', compact('client', 'invoices'));
    }

    public function uploadBukti(Request $request, Invoice $invoice)
    {
        $client = Auth::guard('client')->user();
        if ($invoice->perusahaan_id !== $client->perusahaan_id) {
            abort(403);
        }

        $data = $request->validate([
            'bukti' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:3072'],
        ]);

        $path = $data['bukti']->store("bukti_transfer/{$client->perusahaan_id}", 'public');

        $invoice->update([
            'bukti_transfer_path' => $path,
            'bukti_uploaded_at' => now(),
            'status' => 'terkirim',
        ]);

        return back()->with('success', 'Bukti transfer diupload. Menunggu verifikasi keuangan.');
    }
}
