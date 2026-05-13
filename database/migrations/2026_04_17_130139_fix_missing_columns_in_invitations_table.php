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
            if (!Schema::hasColumn('invitations', 'masa_tamat')) {
                $table->time('masa_tamat')->nullable()->after('masa_majlis');
            }
            if (!Schema::hasColumn('invitations', 'aturcara')) {
                $table->json('aturcara')->nullable()->after('tagline');
            }
            if (!Schema::hasColumn('invitations', 'tema_pakaian')) {
                $table->string('tema_pakaian')->nullable()->after('aturcara');
            }
            if (!Schema::hasColumn('invitations', 'muzik_mp3_url')) {
                $table->string('muzik_mp3_url')->nullable()->after('muzik_youtube_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['masa_tamat', 'aturcara', 'tema_pakaian', 'muzik_mp3_url']);
        });
    }
};
