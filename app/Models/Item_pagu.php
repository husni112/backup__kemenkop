<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_pagu extends Model
{
    use HasFactory;

    protected $fillable = [
        'akun_id',
        'uraian_subkomponen_id',
        'sub_komponen_id',
        'komponen_id',
        'sub_output_id',
        'output_id',
        'kegiatan_id',
        'program_id',
        'kode_mak',
        'cons_item',
        'uraian_item',
        'volume',
        'harga_satuan',
        'total'
    ];

    public function akuns()
    {
        return $this->belongsTo(Akun::class, 'akun_id', 'id');
    }

    public function uraian_subkomponens()
    {
        return $this->belongsTo(Uraian_subkomponen::class, 'uraian_subkomponen_id', 'id');
    }

    public function sub_komponens()
    {
        return $this->belongsTo(Sub_komponen::class, 'sub_komponen_id', 'id');
    }

    public function komponens()
    {
        return $this->belongsTo(Komponen::class, 'komponen_id', 'id');
    }

    public function sub_outputs()
    {
        return $this->belongsTo(Sub_output::class, 'sub_output_id', 'id');
    }

    public function outputs()
    {
        return $this->belongsTo(Output::class, 'output_id', 'id');
    }

    public function kegiatans()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }

    public function programs()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
