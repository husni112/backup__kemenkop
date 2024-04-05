<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uraian_subkomponen extends Model
{
    use HasFactory;

    protected $fillable = [
        'uraian_subkomponen'
    ];

    public function item_pagus()
    {
        return $this->hasMany(Item_pagu::class, 'uraian_subkomponen_id', 'id');
    }
}
