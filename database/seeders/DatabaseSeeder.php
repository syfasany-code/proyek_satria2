<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\PemasukanKas;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::create([
            'nama_admin' => 'Admin Satria',
            'email' => 'admin@satria.test',
            'no_hp' => '0812-0000-0000',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $warga = Warga::create([
            'nik' => '3275010101990001',
            'nama_warga' => 'Budi Santoso',
            'email' => 'budi@satria.test',
            'no_hp' => '0812-3456-7890',
            'alamat' => 'Jl. Ciliwung No. 10, RT 02/RW 03',
            'status_warga' => 'Aktif',
            'username' => 'budi',
            'password' => Hash::make('password'),
            'tanggal_bergabung' => now()->startOfMonth(),
        ]);

        Pembayaran::create([
            'id_warga' => $warga->id_warga,
            'kode_transaksi' => 'SAT-SEED-00001',
            'tanggal_bayar' => now()->subDays(10),
            'nominal_dibayar' => 50000,
            'metode' => 'Transfer Bank',
            'status_verifikasi' => 'Disetujui',
            'catatan' => 'Data dummy pembayaran.',
        ]);

        PemasukanKas::create([
            'id_pembayaran' => null,
            'tanggal' => now()->subDays(15)->toDateString(),
            'sumber_pemasukan' => 'Saldo Awal',
            'keterangan' => 'Saldo awal kas dummy.',
            'nominal' => 100000,
        ]);

        Pengeluaran::create([
            'id_admin' => $admin->id_admin,
            'tanggal' => now()->subDays(5)->toDateString(),
            'keperluan' => 'Perawatan Lampu',
            'keterangan' => 'Perawatan lampu lingkungan.',
            'nominal' => 25000,
        ]);

        PemasukanKas::create([
            'id_pembayaran' => Pembayaran::where('kode_transaksi', 'SAT-SEED-00001')->value('id_pembayaran'),
            'tanggal' => now()->subDays(10)->toDateString(),
            'sumber_pemasukan' => 'Iuran Warga',
            'keterangan' => 'Pembayaran dummy Budi Santoso.',
            'nominal' => 50000,
        ]);
    }
}
