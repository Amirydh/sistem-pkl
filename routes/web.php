<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Import semua controller Anda di sini untuk kerapian
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PesertaController as AdminPesertaController;
use App\Http\Controllers\Admin\PembimbingController as AdminPembimbingController;
use App\Http\Controllers\Admin\LokasiPklController as AdminLokasiPklController;
use App\Http\Controllers\Admin\PenugasanController;

use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
use App\Http\Controllers\Peserta\KegiatanController as PesertaKegiatanController;
use App\Http\Controllers\Peserta\ProfileController as PesertaProfileController;
use App\Http\Controllers\Peserta\AbsensiController as PesertaAbsensiController;

use App\Http\Controllers\Pembimbing\DashboardController as PembimbingDashboardController;
use App\Http\Controllers\Pembimbing\KegiatanController as PembimbingKegiatanController;
use App\Http\Controllers\Pembimbing\AbsensiController as PembimbingAbsensiController;
use App\Http\Controllers\Pembimbing\DaftarController as PembimbingDaftarController;
use Illuminate\Container\Attributes\Auth;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Rute yang Membutuhkan Autentikasi (Harus Login)
|--------------------------------------------------------------------------
| Semua rute di dalam grup ini dilindungi oleh middleware 'auth'.
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute dashboard utama yang mengarahkan pengguna berdasarkan peran
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'pembimbing') {
            return redirect()->route('pembimbing.dashboard');
        } elseif ($user->role === 'peserta') {
            // Middleware CheckProfileCompletion akan menangani redirect jika profil belum lengkap
            return redirect()->route('peserta.dashboard');
        }
        return redirect('/'); // Fallback jika tidak ada peran
    })->name('dashboard');

    // Rute untuk mengelola profil (berlaku untuk semua role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/export', [ProfileController::class, 'exportProfile'])->name('profile.export');


    // --- GRUP ROUTE UNTUK SETIAP PERAN ---

    // GRUP ROUTE UNTUK ADMIN
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('peserta', AdminPesertaController::class)->parameters(['peserta' => 'peserta']);
        Route::resource('pembimbing', AdminPembimbingController::class);
        Route::resource('lokasi-pkl', AdminLokasiPklController::class);

        // RUTE BARU UNTUK HALAMAN PENUGASAN
        Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan.index');
        Route::post('/penugasan', [PenugasanController::class, 'store'])->name('penugasan.store');
    });

    // GRUP ROUTE UNTUK PEMBIMBING
    Route::middleware('role:pembimbing')->prefix('pembimbing')->name('pembimbing.')->group(function () {
        Route::get('/dashboard', [PembimbingDashboardController::class, 'index'])->name('dashboard');
        Route::get('/kegiatan', [PembimbingKegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/kegiatan/{peserta}', [PembimbingKegiatanController::class, 'show'])->name('kegiatan.show');
        Route::post('/kegiatan/{kegiatan}/validasi', [PembimbingKegiatanController::class, 'validasi'])->name('kegiatan.validasi');
        Route::get('/absensi', [PembimbingAbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/{peserta}', [PembimbingAbsensiController::class, 'show'])->name('absensi.show');
        // Route daftar peserta sesuai sidebar dan kebutuhan lain
        Route::get('/peserta', [PembimbingDaftarController::class, 'index'])->name('peserta.index');
    });

    // RUTE KHUSUS UNTUK PESERTA
    Route::middleware('role:peserta')->prefix('peserta')->name('peserta.')->group(function () {
        // Rute untuk melengkapi profil (di luar middleware 'profile.completed')
        Route::get('/profile/create', [PesertaProfileController::class, 'create'])->name('profile.create');
        Route::post('/profile/store', [PesertaProfileController::class, 'store'])->name('profile.store');

        // Grup rute untuk peserta yang SUDAH melengkapi profil
        Route::middleware('profile.completed')->group(function () {
            Route::get('/dashboard', [PesertaDashboardController::class, 'index'])->name('dashboard');
            Route::get('/absensi', [PesertaAbsensiController::class, 'index'])->name('absensi.index');
            Route::get('/absensi/create', [PesertaAbsensiController::class, 'create'])->name('absensi.create');
            Route::post('/absensi', [PesertaAbsensiController::class, 'store'])->name('absensi.store');
            Route::resource('kegiatan', PesertaKegiatanController::class);
        });

       
    });

   
});



require __DIR__ . '/auth.php';
