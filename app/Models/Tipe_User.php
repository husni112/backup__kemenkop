<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipe_User extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe_user',
        'desc'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'tipe_user_id', 'id');
    }
}
