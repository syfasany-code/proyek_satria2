<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tagihan_iuran');

        if (Schema::hasColumn('wargas', 'saldo_deposit')) {
            Schema::table('wargas', function (Blueprint $table) {
                $table->dropColumn('saldo_deposit');
            });
        }

        if (Schema::hasColumn('admins', 'role')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('wargas', 'saldo_deposit')) {
            Schema::table('wargas', function (Blueprint $table) {
                $table->decimal('saldo_deposit', 15, 2)->default(0)->after('status_warga');
            });
        }

        if (!Schema::hasColumn('admins', 'role')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->enum('role', ['Admin Utama', 'Bendahara'])->nullable()->after('password');
            });
        }
    }
};
