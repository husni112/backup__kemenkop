<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [[
            'nik'=> 3209210512000002,
            'nama' => 'Husni Mubarok',
            'role_id' => 3,
            'password' => 123456

        ],
        [
            'nik'=> 3209210512000004,
            'nama' => 'Mas Tejo',
            'role_id' => 2,
            'password' => 123456
        ],
        [
            'nik'=> 3209210512000003,
            'nama' => 'Imam Jakarsih',
            'role_id' => 1,
            'password' => 123456
        ]];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
