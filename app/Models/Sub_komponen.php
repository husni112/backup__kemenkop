<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_komponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_subkomponen',
        'kode_subkomponen',
    ];

    public function item_pagus()
    {
        return $this->hasMany(Item_pagu::class, 'sub_komponen_id', 'id');
    }
}
