<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderTemplate extends Model
{
    protected $fillable = ['nama', 'image_path', 'category', 'aktif', 'urutan'];
}