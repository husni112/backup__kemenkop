<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_komponen',
        'nama_komponen',
    ];

    public function item_pagus()
    {
        return $this->hasMany(Item_pagu::class, 'komponen_id', 'id');
    }
}
