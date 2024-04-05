<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'kode_kegiatan',
    ];

    public function item_pagus()
    {
        return $this->hasMany(Item_pagu::class, 'kegiatan_id', 'id');
    }
}
