<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('gallery_aktif')->default(true)->after('ayat_penutup');
            $table->boolean('aturcara_aktif')->default(true)->after('gallery_aktif');
            $table->boolean('animation_aktif')->default(true)->after('aturcara_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['gallery_aktif', 'aturcara_aktif', 'animation_aktif']);
        });
    }
};
