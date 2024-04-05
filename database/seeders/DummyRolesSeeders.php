<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyRolesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleData = [[
            'role'=>'Admin'
        ],
        [
            'role'=>'Validator'
        ],
        [
            'role'=>'Pegawai'
        ]];

        foreach($roleData as $key => $val){
            Role::create($val);
        }
    }
}
