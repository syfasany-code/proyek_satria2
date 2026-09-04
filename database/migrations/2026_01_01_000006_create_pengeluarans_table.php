<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->foreignId('id_admin')->constrained('admins', 'id_admin')->restrictOnDelete();
            $table->date('tanggal');
            $table->string('keperluan');
            $table->text('keterangan');
            $table->decimal('nominal', 15, 2);
            $table->string('bukti_pengeluaran')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
