<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use Illuminate\Http\Request;

class AuditorController extends Controller
{
    public function index(Request $request)
    {
        $query = Auditor::query();

        if ($q = $request->input('q')) {
            $query->where('nama', 'like', "%{$q}%")
                ->orWhere('no_registrasi', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $auditors = $query->orderBy('nama')->paginate(10)->withQueryString();

        $stats = [
            'total' => Auditor::count(),
            'aktif' => Auditor::where('status', 'aktif')->count(),
            'bertugas' => Auditor::where('beban_kerja', '>', 0)->count(),
            'cuti' => Auditor::where('status', 'cuti')->count(),
        ];

        return view('auditor.index', compact('auditors', 'stats'));
    }

    public function create()
    {
        return view('auditor.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['no_registrasi'] = $data['no_registrasi'] ?: $this->generateNoRegistrasi();
        Auditor::create($data);
        return redirect()->route('admin.auditor.index')->with('success', 'Auditor berhasil ditambahkan.');
    }

    public function show(Auditor $auditor)
    {
        return view('auditor.show', compact('auditor'));
    }

    public function edit(Auditor $auditor)
    {
        return view('auditor.edit', compact('auditor'));
    }

    public function update(Request $request, Auditor $auditor)
    {
        $data = $this->validateData($request, $auditor->id);
        $auditor->update($data);
        return redirect()->route('admin.auditor.index')->with('success', 'Data auditor diperbarui.');
    }

    public function destroy(Auditor $auditor)
    {
        $auditor->delete();
        return redirect()->route('admin.auditor.index')->with('success', 'Auditor dihapus.');
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'no_registrasi' => ['nullable', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:100'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'pendidikan_s1' => ['nullable', 'string'],
            'pendidikan_s2' => ['nullable', 'string'],
            'pendidikan_s3' => ['nullable', 'string'],
            'kompetensi' => ['required', 'in:Junior,Madya,Senior'],
            'status' => ['required', 'in:aktif,non-aktif,cuti'],
            'lokasi_kota' => ['nullable', 'string'],
        ]);
    }

    private function generateNoRegistrasi(): string
    {
        $last = Auditor::orderByDesc('id')->first();
        $next = $last ? ((int) substr($last->no_registrasi, 4)) + 1 : 1;
        return 'AUD-' . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }
}
