<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_bidang',
        'nama_bidang',
    ];

    public function user()
    {
        return $this->hasMany(Bidang::class, 'bidang_id', 'id');
    }
}
