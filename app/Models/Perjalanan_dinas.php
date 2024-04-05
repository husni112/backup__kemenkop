<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perjalanan_dinas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengirim_berkas',
        'berkas_id',
        'bidang_pengirim_berkas',
        'jenis_penyedia',
        'npwp',
        'nik',
        'nama',
        'provinsi',
        'kota',
        'jenis_kegiatan',
        'kode_mak'
    ];

    public function totals()
    {
        return $this->hasMany(Total::class, 'perjalanan_dinas_id', 'id');
    }
}
