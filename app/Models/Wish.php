<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    protected $fillable = [
        'invitation_id', 'nama', 'ucapan'
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}