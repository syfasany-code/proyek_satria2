<?php

namespace App\Http\Controllers;

use App\Models\PemasukanKas;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCashController extends Controller
{
    public function pemasukan(Request $request)
    {
        $items = PemasukanKas::latest('tanggal')->paginate(12);
        return view('admin.pemasukan.index', compact('items'));
    }
    public function storePemasukan(Request $request)
    {
        $data = $request->validate(['tanggal' => 'required|date', 'sumber_pemasukan' => 'required', 'keterangan' => 'required', 'nominal' => 'required|numeric|min:1']);
        PemasukanKas::create($data);
        return back()->with('success', 'Pemasukan ditambahkan.');
    }
    public function destroyPemasukan(PemasukanKas $pemasukan)
    {
        if ($pemasukan->id_pembayaran) return back()->with('error', 'Pemasukan dari pembayaran tidak boleh dihapus dari menu manual.');
        $pemasukan->delete();
        return back()->with('success', 'Pemasukan dihapus.');
    }
    public function pengeluaran(Request $request)
    {
        $items = Pengeluaran::with('admin')->latest('tanggal')->paginate(12);
        return view('admin.pengeluaran.index', compact('items'));
    }
    public function storePengeluaran(Request $request)
    {
        $data = $request->validate(['tanggal' => 'required|date', 'keperluan' => 'required', 'keterangan' => 'required', 'nominal' => 'required|numeric|min:1', 'bukti_pengeluaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048']);
        $data['id_admin'] = Auth::guard('admin')->id();
        $data['bukti_pengeluaran'] = $request->hasFile('bukti_pengeluaran') ? $request->file('bukti_pengeluaran')->store('bukti-pengeluaran', 'public') : null;
        Pengeluaran::create($data);
        return back()->with('success', 'Pengeluaran ditambahkan.');
    }
    public function destroyPengeluaran(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        return back()->with('success', 'Pengeluaran dihapus.');
    }
}
