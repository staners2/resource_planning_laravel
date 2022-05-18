<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            ['id' => '1', 'name' => 'user']
        );
        DB::table('roles')->insert(
            ['id' => '2', 'name' => 'admin']
        );
        DB::table('users')->insert(
            ['name' => 'staners2', 'email' => 'dima.aratin@mail.ru', 'password' => Hash::make('123456')]
        );
    }
}
