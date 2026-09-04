<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WargaDashboardController;
use App\Http\Controllers\WargaPaymentController;
use App\Http\Controllers\WargaProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminWargaController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminCashController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminProfileController;

Route::redirect('/', '/warga/login');

Route::middleware('guest:warga')->prefix('warga')->name('warga.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginWarga'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticateWarga'])->name('login.submit');

    Route::get('/lupa-password', [AuthController::class, 'forgotWarga'])->name('password.request');
    Route::post('/lupa-password', [AuthController::class, 'sendResetWarga'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetWargaForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetWarga'])->name('password.update');
});

Route::middleware('auth:warga')->prefix('warga')->name('warga.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logoutWarga'])->name('logout');

    Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

    Route::get('/bayar', [WargaPaymentController::class, 'index'])->name('bayar');
    Route::post('/bayar', [WargaPaymentController::class, 'store'])->name('bayar.store');

    Route::get('/riwayat-pembayaran', [WargaPaymentController::class, 'history'])->name('riwayat');

    Route::get('/profil', [WargaProfileController::class, 'index'])->name('profil');
    Route::put('/profil', [WargaProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [WargaProfileController::class, 'password'])->name('profil.password');
});

Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginAdmin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticateAdmin'])->name('login.submit');

    Route::get('/lupa-password', [AuthController::class, 'forgotAdmin'])->name('password.request');
    Route::post('/lupa-password', [AuthController::class, 'sendResetAdmin'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetAdminForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetAdmin'])->name('password.update');
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logoutAdmin'])->name('logout');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/warga', [AdminWargaController::class, 'index'])->name('warga.index');
    Route::post('/warga', [AdminWargaController::class, 'store'])->name('warga.store');
    Route::put('/warga/{warga}', [AdminWargaController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{warga}', [AdminWargaController::class, 'destroy'])->name('warga.destroy');

    Route::get('/pembayaran', [AdminPaymentController::class, 'index'])->name('pembayaran.index');
    Route::put('/pembayaran/{pembayaran}/verifikasi', [AdminPaymentController::class, 'verify'])->name('pembayaran.verify');

    Route::get('/pemasukan', [AdminCashController::class, 'pemasukan'])->name('pemasukan.index');
    Route::post('/pemasukan', [AdminCashController::class, 'storePemasukan'])->name('pemasukan.store');
    Route::delete('/pemasukan/{pemasukan}', [AdminCashController::class, 'destroyPemasukan'])->name('pemasukan.destroy');

    Route::get('/pengeluaran', [AdminCashController::class, 'pengeluaran'])->name('pengeluaran.index');
    Route::post('/pengeluaran', [AdminCashController::class, 'storePengeluaran'])->name('pengeluaran.store');
    Route::delete('/pengeluaran/{pengeluaran}', [AdminCashController::class, 'destroyPengeluaran'])->name('pengeluaran.destroy');

    Route::get('/laporan', [AdminReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [AdminReportController::class, 'export'])->name('laporan.export');

    Route::get('/profil', [AdminProfileController::class, 'index'])->name('profil');
    Route::put('/profil', [AdminProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [AdminProfileController::class, 'password'])->name('profil.password');
});