<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_output extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_suboutput',
        'nama_suboutput',
    ];

    public function item_pagus()
    {
        return $this->hasMany(Item_pagu::class, 'sub_output_id', 'id');
    }
}
