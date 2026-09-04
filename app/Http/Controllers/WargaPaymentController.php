<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Services\IuranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WargaPaymentController extends Controller
{
    public function index(IuranService $iuranService)
    {
        $warga = Auth::guard('warga')->user();

        abort_unless($warga, 403);

        $summary = $iuranService->hitungStatus($warga);
        $status = $summary;

        return view('warga.bayar', compact('warga', 'status', 'summary'));
    }

    public function store(Request $request)
    {
        $warga = Auth::guard('warga')->user();

        abort_unless($warga, 403);

        $data = $request->validate(
            [
                'nominal_dibayar' => ['required', 'numeric', 'min:1'],
                'metode' => ['required', 'in:Transfer Bank,Tunai'],
                'bukti_transfer' => [
                    'nullable',
                    'required_if:metode,Transfer Bank',
                    'file',
                    'mimes:jpg,jpeg,png,pdf',
                    'max:5120',
                ],
            ],
            [
                'nominal_dibayar.required' => 'Nominal pembayaran wajib diisi.',
                'nominal_dibayar.numeric' => 'Nominal pembayaran harus berupa angka.',
                'nominal_dibayar.min' => 'Nominal pembayaran minimal Rp1.',
                'metode.required' => 'Metode pembayaran wajib dipilih.',
                'metode.in' => 'Metode pembayaran tidak valid.',
                'bukti_transfer.required_if' => 'Bukti pembayaran wajib diunggah untuk Transfer Bank.',
                'bukti_transfer.file' => 'Bukti pembayaran harus berupa file.',
                'bukti_transfer.mimes' => 'Bukti pembayaran harus JPG, JPEG, PNG, atau PDF.',
                'bukti_transfer.max' => 'Ukuran bukti pembayaran maksimal 5 MB.',
            ]
        );

        $buktiTransfer = null;

        if ($data['metode'] === 'Transfer Bank') {
            $buktiTransfer = $request->file('bukti_transfer')->store(
                'bukti-transfer',
                'public'
            );
        }

        $pembayaran = Pembayaran::create([
            'id_warga' => $warga->id_warga,
            'kode_transaksi' => 'SAT-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5)),
            'tanggal_bayar' => now(),
            'nominal_dibayar' => $data['nominal_dibayar'],
            'metode' => $data['metode'],
            'bukti_transfer' => $buktiTransfer,
            'status_verifikasi' => 'Pending',
            'catatan' => null,
        ]);

        return redirect()
            ->route('warga.riwayat')
            ->with(
                'success',
                'Pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.'
            );
    }

    public function history(Request $request)
    {
        $warga = Auth::guard('warga')->user();

        abort_unless($warga, 403);

        $query = Pembayaran::query()
            ->where('id_warga', $warga->id_warga)
            ->latest('tanggal_bayar');

        if ($request->filled('status')) {
            $status = $request->status;

            if (in_array($status, ['Disetujui', 'Pending', 'Ditolak'], true)) {
                $query->where('status_verifikasi', $status);
            }
        }

        $pembayaran = $query->paginate(10)->withQueryString();

        return view(
            'warga.riwayat_pembayaran',
            compact('warga', 'pembayaran')
        );
    }

    public function preview(Request $request, IuranService $iuranService)
    {
        $warga = Auth::guard('warga')->user();

        abort_unless($warga, 403);

        $nominal = (float) $request->input('nominal_dibayar', 0);

        if ($nominal < 0) {
            $nominal = 0;
        }

        return response()->json(
            $iuranService->previewPembayaran($warga, $nominal)
        );
    }
}