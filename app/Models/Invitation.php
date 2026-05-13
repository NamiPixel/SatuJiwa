<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Invitation extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'expires_at',
        'nama_majlis', 'jenis_majlis',
        'bilangan_pengantin', 'bilangan_pihak',
        'nama_pengantin_lelaki', 'nama_pengantin_perempuan',
        'nama_ringkas_lelaki', 'nama_ringkas_perempuan',
        'tarikh_majlis', 'masa_majlis', 'masa_tamat',
        'alamat_majlis', 'google_maps_url', 'waze_url',
        'no_whatsapp', 'no_hubungi_2', 'no_hubungi_3',
        'no_telefon', 'nama_hubungi_1', 'nama_hubungi_2', 'nama_hubungi_3',
        'tagline',
        'nama_bapa_lelaki', 'nama_ibu_lelaki',
        'nama_bapa_perempuan', 'nama_ibu_perempuan',
        'ayat_jemputan', 'ayat_penutup',
        'tema_warna', 'warna_bg', 'warna_aksen',
        'fon_tajuk', 'fon_badan', 'header_image',
        'muzik_aktif', 'muzik_youtube_url', 'muzik_volume',
        'pranikah_aktif', 'pranikah_tajuk', 'pranikah_cerita',
        'rsvp_aktif', 'rsvp_tutup', 'rsvp_maksimum',
        'hadiah_aktif', 'bank_nama_akaun', 'bank_nama',
        'bank_no_akaun', 'qr_image',
        'tema_pakaian', 
        'aturcara',
        'gallery_aktif', 'aturcara_aktif', 'animation_aktif', 'animation_type',
        'muzik_mp3_url',
    ];

    protected $casts = [
        'tarikh_majlis'  => 'date',
        'expires_at'     => 'datetime',
        'rsvp_tutup'     => 'date',
        'muzik_aktif'    => 'boolean',
        'pranikah_aktif' => 'boolean',
        'rsvp_aktif'     => 'boolean',
        'hadiah_aktif'   => 'boolean',
        'gallery_aktif'  => 'boolean',
        'aturcara_aktif' => 'boolean',
        'animation_aktif'=> 'boolean',
        'aturcara'       => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class)->orderBy('urutan');
    }

    public function galleryImages()
    {
        return $this->hasMany(Gallery::class)->where('jenis', 'gallery')->orderBy('urutan');
    }

    public function pranikahImages()
    {
        return $this->hasMany(Gallery::class)->where('jenis', 'pranikah')->orderBy('urutan');
    }

    public function rsvpResponses()
    {
        return $this->hasMany(RsvpResponse::class);
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class)->latest();
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}