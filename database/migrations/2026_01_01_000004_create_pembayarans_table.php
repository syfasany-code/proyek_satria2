<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_warga')->constrained('wargas', 'id_warga')->cascadeOnDelete();
            $table->string('kode_transaksi')->unique();
            $table->dateTime('tanggal_bayar');
            $table->decimal('nominal_dibayar', 15, 2);
            $table->enum('metode', ['Transfer Bank', 'Tunai']);
            $table->string('bukti_transfer')->nullable();
            $table->enum('status_verifikasi', ['Disetujui', 'Pending', 'Ditolak'])->default('Pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
