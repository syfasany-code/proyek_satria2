<?php

namespace App\Http\Controllers;

use App\Models\PemasukanKas;
use App\Models\Pengeluaran;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->date('from')?->startOfDay() ?: now()->startOfMonth();
        $to = $request->date('to')?->endOfDay() ?: now()->endOfDay();

        if ($from->greaterThan($to)) {
            [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()];
        }

        $totalPemasukan = (float) PemasukanKas::sum('nominal');
        $totalPengeluaran = (float) Pengeluaran::sum('nominal');
        $saldoKas = $totalPemasukan - $totalPengeluaran;
        $pemasukanPeriode = (float) PemasukanKas::whereBetween('tanggal', [$from->toDateString(), $to->toDateString()])->sum('nominal');
        $pengeluaranPeriode = (float) Pengeluaran::whereBetween('tanggal', [$from->toDateString(), $to->toDateString()])->sum('nominal');
        $jumlahWarga = Warga::count();

        $recentIn = PemasukanKas::with('pembayaran.warga')
            ->latest('tanggal')
            ->take(5)
            ->get();

        $recentOut = Pengeluaran::with('admin')
            ->latest('tanggal')
            ->take(5)
            ->get();

        $months = [];
        $inSeries = [];
        $outSeries = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->startOfMonth()->subMonths($i);
            $months[] = $date->locale('id')->translatedFormat('M Y');
            $inSeries[] = (float) PemasukanKas::whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('nominal');
            $outSeries[] = (float) Pengeluaran::whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('nominal');
        }

        return view('admin.dashboard', compact(
            'from',
            'to',
            'saldoKas',
            'pemasukanPeriode',
            'pengeluaranPeriode',
            'jumlahWarga',
            'recentIn',
            'recentOut',
            'months',
            'inSeries',
            'outSeries'
        ));
    }
}
