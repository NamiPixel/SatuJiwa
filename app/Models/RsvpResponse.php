<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RsvpResponse extends Model
{
    protected $fillable = [
        'invitation_id', 'nama', 'status', 'jumlah_hadir'
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}