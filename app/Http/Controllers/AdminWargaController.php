<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Services\IuranService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class AdminWargaController extends Controller
{
    public function index(Request $request, IuranService $service)
    {
        $wargas = Warga::query()
            ->withSum(['pembayarans as total_pembayaran_disetujui' => function ($query) {
                $query->where('status_verifikasi', 'Disetujui')->where('tanggal_bayar', '<=', now());
            }], 'nominal_dibayar')
            ->latest('id_warga')
            ->get();

        $wargas->each(function (Warga $warga) use ($service) {
            $warga->status_pembayaran = $service->hitungStatus(
                $warga,
                (float) ($warga->total_pembayaran_disetujui ?? 0)
            );
        });

        if ($request->filled('q')) {
            $keyword = mb_strtolower(trim($request->q));
            $wargas = $wargas->filter(function (Warga $warga) use ($keyword) {
                return str_contains(mb_strtolower($warga->nama_warga), $keyword)
                    || str_contains(mb_strtolower($warga->nik), $keyword);
            });
        }

        if ($request->filled('status_pembayaran') && in_array($request->status_pembayaran, ['Lunas', 'Menunggak'], true)) {
            $wargas = $wargas->filter(function (Warga $warga) use ($request) {
                return $warga->status_pembayaran['status'] === $request->status_pembayaran;
            });
        }

        $wargas = $this->paginateCollection($wargas->values(), 10, $request);

        return view('admin.warga.index', compact('wargas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik' => ['required', 'string', 'max:30', 'unique:wargas,nik'],
            'nama_warga' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:wargas,email'],
            'no_hp' => ['required', 'string', 'max:25'],
            'alamat' => ['required', 'string'],
            'username' => ['required', 'string', 'max:255', 'unique:wargas,username'],
            'password' => ['required', 'string', 'min:8'],
            'status_warga' => ['required', 'in:Aktif,Nonaktif'],
            'tanggal_bergabung' => ['required', 'date'],
        ]);

        $data['password'] = Hash::make($data['password']);

        Warga::create($data);

        return back()->with('success', 'Warga berhasil ditambahkan.');
    }

    public function update(Request $request, Warga $warga)
    {
        $data = $request->validate([
            'nik' => ['required', 'string', 'max:30', 'unique:wargas,nik,' . $warga->id_warga . ',id_warga'],
            'nama_warga' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:wargas,email,' . $warga->id_warga . ',id_warga'],
            'no_hp' => ['required', 'string', 'max:25'],
            'alamat' => ['required', 'string'],
            'username' => ['required', 'string', 'max:255', 'unique:wargas,username,' . $warga->id_warga . ',id_warga'],
            'status_warga' => ['required', 'in:Aktif,Nonaktif'],
            'tanggal_bergabung' => ['required', 'date'],
        ]);

        Warga::where('id_warga', $warga->id_warga)->update($data);

        return back()->with('success', 'Data warga diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();

        return back()->with('success', 'Warga dihapus.');
    }

    private function paginateCollection(Collection $items, int $perPage, Request $request): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $results = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $results,
            $items->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}
