<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    use HasFactory;

    protected $fillable = [
        'perjalanan_dinas_id',
        'rincian_item',
        'total',
    ];

    public function perjalanan_dinass()
    {
        return $this->belongsTo(perjalanan_dinas::class, 'perjalanan_dinas_id', 'id');
    }
}
