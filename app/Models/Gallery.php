<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'invitation_id',
        'image_path',
        'jenis',
        'urutan',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}