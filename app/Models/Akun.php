<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_akun',
        'kode_akun',
    ];

    public function item_pagus()
    {
        return $this->hasMany(Item_pagu::class, 'akun_id', 'id');
    }
}
