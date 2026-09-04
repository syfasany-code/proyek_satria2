<?php

namespace App\Http\Controllers;

use App\Models\PemasukanKas;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->date('from')?->startOfDay() ?: now()->startOfMonth();
        $to = $request->date('to')?->endOfDay() ?: now()->endOfDay();
        $pemasukan = PemasukanKas::whereBetween('tanggal', [$from, $to])->orderBy('tanggal')->get();
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$from, $to])->orderBy('tanggal')->get();
        $totalIn = $pemasukan->sum('nominal');
        $totalOut = $pengeluaran->sum('nominal');
        $saldo = $totalIn - $totalOut;
        return view('admin.laporan.index', compact('from', 'to', 'pemasukan', 'pengeluaran', 'totalIn', 'totalOut', 'saldo'));
    }
    public function export(Request $request)
    {
        $from = $request->date('from')?->format('Y-m-d') ?: now()->startOfMonth()->format('Y-m-d');
        $to = $request->date('to')?->format('Y-m-d') ?: now()->format('Y-m-d');
        $rows = PemasukanKas::whereBetween('tanggal', [$from, $to])->get();
        $csv = 'Tanggal,Sumber,Keterangan,Nominal\n';
        foreach ($rows as $r) $csv .= sprintf('%s,%s,"%s",%s\n', $r->tanggal->format('Y-m-d'), $r->sumber_pemasukan, str_replace('"', '""', $r->keterangan), $r->nominal);
        return response($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="laporan-satria.csv"']);
    }
}
