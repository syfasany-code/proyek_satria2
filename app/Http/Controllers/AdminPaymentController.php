<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\PemasukanKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('warga')->latest('tanggal_bayar');

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        $pembayaran = $query->paginate(12)->withQueryString();

        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    public function verify(Request $request, Pembayaran $pembayaran)
    {
        $data = $request->validate([
            'status_verifikasi' => ['required', 'in:Disetujui,Ditolak'],
            'catatan' => ['nullable', 'string'],
        ]);

        if ($pembayaran->status_verifikasi !== 'Pending') {
            return back()->with('error', 'Transaksi sudah diverifikasi.');
        }

        DB::transaction(function () use ($data, $pembayaran) {
            $pembayaran->update([
                'status_verifikasi' => $data['status_verifikasi'],
                'catatan' => $data['catatan'] ?? null,
            ]);

            if ($data['status_verifikasi'] === 'Disetujui') {
                PemasukanKas::create([
                    'id_pembayaran' => $pembayaran->id_pembayaran,
                    'tanggal' => $pembayaran->tanggal_bayar->toDateString(),
                    'sumber_pemasukan' => 'Iuran Warga',
                    'keterangan' => 'Pembayaran ' . $pembayaran->kode_transaksi . ' - ' . $pembayaran->warga->nama_warga,
                    'nominal' => $pembayaran->nominal_dibayar,
                ]);
            }
        });

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}
