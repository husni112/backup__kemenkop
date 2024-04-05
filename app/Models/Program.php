<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_program',
        'nama_program'
    ];

    public function item_pagus()
    {
        return $this->hasMany(Item_pagu::class, 'program_id', 'id');
    }
}
