<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'name'=>'msallam',
            'email'=>'msallam@gmail.com',
            'password'=>Hash::make('secret1234'),
            'phone'=>'098765432'
        ]);

        $super_admin=Role::where('name','super_admin')->get();

        $user->roles()->attach($super_admin);
    }
}
