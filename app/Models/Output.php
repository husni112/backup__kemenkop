<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_output',
        'nama_output',
    ];

    public function item_pagus()
    {
        return $this->hasMany(Item_pagu::class, 'output_id', 'id');
    }
}
