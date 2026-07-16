<?php

use App\Http\Controllers\AuditorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiayaClientController;
use App\Http\Controllers\ClientManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentVerificationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PemilihanAuditorController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\Portal\PortalAuthController;
use App\Http\Controllers\Portal\PortalDashboardController;
use App\Http\Controllers\Portal\PortalDocumentController;
use App\Http\Controllers\Portal\PortalInvoiceController;
use App\Http\Controllers\Portal\PortalPenawaranController;
use App\Http\Controllers\Portal\PortalProfilController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SertifikatHalalController;
use App\Http\Controllers\SuratTugasController;
use Illuminate\Support\Facades\Route;

// ============ LANDING PAGE (public) ============
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/tentang', [LandingController::class, 'tentang'])->name('landing.tentang');
Route::get('/layanan', [LandingController::class, 'layanan'])->name('landing.layanan');
Route::get('/kontak', [LandingController::class, 'kontak'])->name('landing.kontak');

// ============ ADMIN / STAFF (existing app) ============
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.login'));
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::middleware('role:operasional,keuangan')->group(function () {
            Route::resource('auditor', AuditorController::class);
            Route::resource('perusahaan', PerusahaanController::class);
            Route::get('/api/perusahaan/{perusahaan}/info', [PerusahaanController::class, 'apiInfo'])->name('api.perusahaan.info');
            Route::resource('surat-tugas', SuratTugasController::class)->parameters(['surat-tugas' => 'suratTuga']);
            Route::resource('sertifikat', SertifikatHalalController::class);

            Route::get('/pemilihan-auditor', [PemilihanAuditorController::class, 'index'])->name('pemilihan-auditor.index');
            Route::post('/pemilihan-auditor/assign', [PemilihanAuditorController::class, 'assign'])->name('pemilihan-auditor.assign');

            // Verifikasi dokumen dari klien
            Route::get('/verifikasi-dokumen', [DocumentVerificationController::class, 'index'])->name('verifikasi-dokumen.index');
            Route::get('/verifikasi-dokumen/{document}', [DocumentVerificationController::class, 'show'])->name('verifikasi-dokumen.show');
            Route::post('/verifikasi-dokumen/{document}/approve', [DocumentVerificationController::class, 'approve'])->name('verifikasi-dokumen.approve');
            Route::post('/verifikasi-dokumen/{document}/reject', [DocumentVerificationController::class, 'reject'])->name('verifikasi-dokumen.reject');
            Route::post('/verifikasi-dokumen/{document}/reset', [DocumentVerificationController::class, 'resetStatus'])->name('verifikasi-dokumen.reset');

            // Manajemen Klien Portal
            Route::get('/klien', [ClientManagementController::class, 'index'])->name('klien.index');
            Route::get('/klien/{client}', [ClientManagementController::class, 'show'])->name('klien.show');
            Route::post('/klien/{client}/toggle', [ClientManagementController::class, 'toggleActive'])->name('klien.toggle');
            Route::post('/klien/{client}/reset-password', [ClientManagementController::class, 'resetPassword'])->name('klien.reset-password');
            Route::delete('/klien/{client}', [ClientManagementController::class, 'destroy'])->name('klien.destroy');

            Route::get('/report/surat-tugas/{suratTuga}', [ReportController::class, 'suratTugas'])->name('report.surat-tugas');
            Route::get('/report/statement-letter/{perusahaan}', [ReportController::class, 'statementLetter'])->name('report.statement-letter');
            Route::get('/report/audit-report/{suratTuga}', [ReportController::class, 'auditReport'])->name('report.audit-report');
        });

        Route::middleware('role:keuangan,operasional')->group(function () {
            Route::resource('penawaran', PenawaranController::class);
            Route::resource('biaya-client', BiayaClientController::class)->parameters(['biaya-client' => 'biayaClient']);
            Route::resource('invoice', InvoiceController::class);

            Route::get('/report/quotation/{penawaran}', [ReportController::class, 'quotation'])->name('report.quotation');
            Route::get('/report/pembiayaan/{penawaran}', [ReportController::class, 'pembiayaan'])->name('report.pembiayaan');
            Route::get('/report/invoice/{invoice}', [ReportController::class, 'invoiceDn'])->name('report.invoice');
            Route::get('/report/invoice-ln/{invoice}', [ReportController::class, 'invoiceLn'])->name('report.invoice-ln');
        });
    });
});

// ============ PORTAL KLIEN ============
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', fn () => redirect()->route('portal.login'));
    Route::middleware('guest:client')->group(function () {
        Route::get('/login', [PortalAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [PortalAuthController::class, 'login'])->name('login.submit');
        Route::get('/register', [PortalAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [PortalAuthController::class, 'register'])->name('register.submit');
    });

    Route::middleware('auth:client')->group(function () {
        Route::post('/logout', [PortalAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [PortalDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [PortalProfilController::class, 'edit'])->name('profil');
        Route::put('/profil', [PortalProfilController::class, 'update'])->name('profil.update');
        Route::get('/dokumen', [PortalDocumentController::class, 'index'])->name('dokumen');
        Route::post('/dokumen', [PortalDocumentController::class, 'upload'])->name('dokumen.upload');
        Route::delete('/dokumen/{document}', [PortalDocumentController::class, 'destroy'])->name('dokumen.destroy');
        Route::get('/penawaran', [PortalPenawaranController::class, 'index'])->name('penawaran');
        Route::post('/penawaran/{penawaran}/approve', [PortalPenawaranController::class, 'approve'])->name('penawaran.approve');
        Route::get('/invoice', [PortalInvoiceController::class, 'index'])->name('invoice');
        Route::post('/invoice/{invoice}/upload-bukti', [PortalInvoiceController::class, 'uploadBukti'])->name('invoice.uploadBukti');
    });
});

// ============ Legacy redirects ============
Route::get('/login', fn () => redirect()->route('admin.login'));
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'));
