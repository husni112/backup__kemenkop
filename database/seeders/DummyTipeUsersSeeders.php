<?php

namespace Database\Seeders;

use App\Models\TipeUsers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyTipeUsersSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipe_userData = [[
            'tipe_user'=>'Admin'
        ],
        [
            'tipe_user'=>'Pegawai'
        ]];

        foreach($tipe_userData as $key => $val){
            TipeUsers::create($val);
        }
    }
}
