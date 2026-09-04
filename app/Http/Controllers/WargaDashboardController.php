<?php

namespace App\Http\Controllers;

use App\Models\PemasukanKas;
use App\Models\Pengeluaran;
use App\Services\IuranService;
use Illuminate\Support\Facades\Auth;

class WargaDashboardController extends Controller
{
    public function index(IuranService $service)
    {
        $warga = Auth::guard('warga')->user();
        $summary = $service->hitungStatus($warga);
        $status = $summary;
        $pemasukan = PemasukanKas::latest('tanggal')->take(5)->get();
        $pengeluaran = Pengeluaran::latest('tanggal')->take(5)->get();
        $totalIn = (float) PemasukanKas::sum('nominal');
        $totalOut = (float) Pengeluaran::sum('nominal');

        return view('warga.dashboard', compact(
            'warga',
            'summary',
            'status',
            'pemasukan',
            'pengeluaran',
            'totalIn',
            'totalOut'
        ));
    }
}
