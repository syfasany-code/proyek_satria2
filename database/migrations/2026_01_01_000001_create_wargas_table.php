<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id('id_warga');
            $table->string('nik', 30)->unique();
            $table->string('nama_warga');
            $table->string('email')->unique();
            $table->string('no_hp', 25);
            $table->text('alamat');
            $table->enum('status_warga', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->date('tanggal_bergabung');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
