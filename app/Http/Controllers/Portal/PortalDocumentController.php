<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\ClientDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalDocumentController extends Controller
{
    public const JENIS_DOKUMEN = [
        'KTP PIC' => 'KTP Penanggung Jawab',
        'NIB' => 'Nomor Induk Berusaha (NIB) dari OSS',
        'Daftar Produk' => 'Daftar Nama Produk yang Diajukan',
        'Daftar Bahan' => 'Daftar Bahan Baku & Supplier',
        'Proses Produksi' => 'Diagram Alir Proses Produksi',
        'Sertifikat Bahan Halal' => 'Sertifikat Halal Bahan Baku (jika ada)',
        'Manual SJPH' => 'Manual Sistem Jaminan Produk Halal',
        'Sertifikat Penyelia' => 'Sertifikat Penyelia Halal',
        'Layout Pabrik' => 'Layout / Denah Pabrik',
    ];

    public function index()
    {
        $client = Auth::guard('client')->user();
        $documents = $client->documents()->latest()->get()->groupBy('jenis_dokumen');
        $jenisDokumen = self::JENIS_DOKUMEN;
        return view('portal.dokumen', compact('client', 'documents', 'jenisDokumen'));
    }

    public function upload(Request $request)
    {
        $client = Auth::guard('client')->user();
        if (! $client->perusahaan_id) {
            return back()->withErrors(['file' => 'Perusahaan belum terhubung dengan akun.']);
        }

        $data = $request->validate([
            'jenis_dokumen' => ['required', 'string', 'in:' . implode(',', array_keys(self::JENIS_DOKUMEN))],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $file = $request->file('file');
        $path = $file->store("documents/{$client->perusahaan_id}", 'public');

        ClientDocument::create([
            'perusahaan_id' => $client->perusahaan_id,
            'client_id' => $client->id,
            'jenis_dokumen' => $data['jenis_dokumen'],
            'nama_file' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'status' => 'pending',
        ]);

        return redirect()->route('portal.dokumen')->with('success', 'Dokumen berhasil diupload, menunggu verifikasi staf.');
    }

    public function destroy(ClientDocument $document)
    {
        $client = Auth::guard('client')->user();
        if ($document->client_id !== $client->id) {
            abort(403);
        }
        if ($document->status === 'approved') {
            return back()->withErrors(['file' => 'Dokumen sudah diverifikasi, tidak bisa dihapus.']);
        }
        \Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Dokumen dihapus.');
    }
}
