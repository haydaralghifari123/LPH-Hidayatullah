<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use App\Models\Perusahaan;
use App\Models\SertifikatHalal;

class LandingController extends Controller
{
    public function index()
    {
        $stats = [
            'produk' => 50000,
            'usaha' => Perusahaan::count() + 2500,
            'auditor' => Auditor::count(),
            'sertifikat' => SertifikatHalal::count() + 400,
        ];
        return view('landing.index', compact('stats'));
    }

    public function tentang()
    {
        return view('landing.tentang');
    }

    public function layanan()
    {
        return view('landing.layanan');
    }

    public function kontak()
    {
        return view('landing.kontak');
    }
}
