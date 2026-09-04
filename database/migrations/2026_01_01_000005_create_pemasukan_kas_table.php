<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pemasukan_kas', function (Blueprint $table) {
            $table->id('id_pemasukan');
            $table->foreignId('id_pembayaran')->nullable()->constrained('pembayarans', 'id_pembayaran')->nullOnDelete();
            $table->date('tanggal');
            $table->string('sumber_pemasukan');
            $table->text('keterangan');
            $table->decimal('nominal', 15, 2);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pemasukan_kas');
    }
};
