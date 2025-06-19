<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'=>'super_admin',
            'description'=>'this role has permission to do every thing'
        ]);

        Role::create([
            'name'=>'delivery_manger',
            'description'=>'this role has permission to do mangment order'
        ]);

        Role::create([
            'name'=>'restaurent_manger',
            'description'=>'this role has permission to do mangment meal , category,offer'
        ]);


         Role::create([
            'name'=>'delivery_worker',
            'description'=>'this role has permission to do delivery order'
        ]);

         Role::create([
            'name'=>'customer',
            'description'=>'this role has permission to do order'
        ]);
    }
}
