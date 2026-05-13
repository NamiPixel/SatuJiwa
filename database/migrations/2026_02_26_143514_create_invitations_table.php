<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique(); // akif-aliya
            $table->timestamp('expires_at')->nullable();

            // Maklumat Majlis
            $table->string('nama_majlis')->default('Walimatul Urus');
            $table->string('jenis_majlis')->default('Perkahwinan');
            $table->string('nama_pengantin_lelaki')->nullable();
            $table->string('nama_pengantin_perempuan')->nullable();
            $table->string('nama_ringkas_lelaki')->nullable();
            $table->string('nama_ringkas_perempuan')->nullable();
            $table->date('tarikh_majlis')->nullable();
            $table->time('masa_majlis')->nullable();
            $table->text('alamat_majlis')->nullable();
            $table->string('google_maps_url')->nullable();
            $table->string('waze_url')->nullable();
            $table->string('no_whatsapp')->nullable();
            $table->string('no_telefon')->nullable();
            $table->text('tagline')->nullable();

            // Teks Jemputan
            $table->string('nama_bapa_lelaki')->nullable();
            $table->string('nama_ibu_lelaki')->nullable();
            $table->string('nama_bapa_perempuan')->nullable();
            $table->string('nama_ibu_perempuan')->nullable();
            $table->text('ayat_jemputan')->nullable();
            $table->text('ayat_penutup')->nullable();

            // Reka Bentuk
            $table->string('tema_warna')->default('emas-klasik');
            $table->string('warna_bg')->default('#0F0B06');
            $table->string('warna_aksen')->default('#C9A96E');
            $table->string('fon_tajuk')->default('Cormorant Garamond');
            $table->string('fon_badan')->default('DM Sans');
            $table->string('header_image')->nullable();

            // Muzik
            $table->boolean('muzik_aktif')->default(true);
            $table->string('muzik_youtube_url')->nullable();
            $table->integer('muzik_volume')->default(60);

            // Seksyen toggle
            $table->boolean('pranikah_aktif')->default(true);
            $table->string('pranikah_tajuk')->default('Kisah Kita');
            $table->text('pranikah_cerita')->nullable();
            $table->boolean('rsvp_aktif')->default(true);
            $table->date('rsvp_tutup')->nullable();
            $table->integer('rsvp_maksimum')->default(0);
            $table->boolean('hadiah_aktif')->default(true);

            // Hadiah Wang
            $table->string('bank_nama_akaun')->nullable();
            $table->string('bank_nama')->nullable();
            $table->string('bank_no_akaun')->nullable();
            $table->string('qr_image')->nullable();

            // Lokasi koordinat
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};