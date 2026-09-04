<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihan_iuran', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->foreignId('id_warga')->constrained('wargas', 'id_warga')->cascadeOnDelete();
            $table->string('bulan_tahun', 30);
            $table->decimal('nominal_tarif', 15, 2)->default(15000);
            $table->decimal('nominal_terbayar', 15, 2)->default(0);
            $table->decimal('sisa_tagihan', 15, 2)->default(15000);
            $table->enum('status', ['Lunas', 'Menunggak'])->default('Menunggak');
            $table->timestamps();
            $table->unique(['id_warga', 'bulan_tahun']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tagihan_iuran');
    }
};
