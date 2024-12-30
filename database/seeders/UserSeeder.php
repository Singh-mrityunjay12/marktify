<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [

            'full_name'=>'Admin user',
            'username'=>'adminuser',
            'email'=>'admin@gmail.com',
            'role'=>0,
            'role_type'=>'ADMIN',
            
            'password'=>bcrypt('password'),
          ],
          [
            'full_name'=>'Vendor user',
            'username'=>'vendoruser',
            'email'=>'vendor@gmail.com',
            'role'=>2,
            'role_type'=>'VENDOR',
            
            'password'=>bcrypt('password'),
        ],

        [

            'full_name'=>'User',
            'username'=>'user',
            'email'=>'user@gmail.com',
            'role'=>1,
            'role_type'=>'USER',
            
            'password'=>bcrypt('password'),
        ],
    ]);
    }
}
