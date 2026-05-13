<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            // Mod pengantin (1 atau 2 nama)
            $table->integer('bilangan_pengantin')->default(2)->after('jenis_majlis');
            // Mod ibu bapa (1 atau 2 pihak)
            $table->integer('bilangan_pihak')->default(2)->after('bilangan_pengantin');
            // Nombor hubungi tambahan
            $table->string('no_hubungi_2')->nullable()->after('no_whatsapp');
            $table->string('no_hubungi_3')->nullable()->after('no_hubungi_2');
            $table->string('nama_hubungi_1')->nullable()->after('no_telefon');
            $table->string('nama_hubungi_2')->nullable()->after('nama_hubungi_1');
            $table->string('nama_hubungi_3')->nullable()->after('nama_hubungi_2');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['bilangan_pengantin','bilangan_pihak','no_hubungi_2','no_hubungi_3','nama_hubungi_1','nama_hubungi_2','nama_hubungi_3']);
        });
    }
};