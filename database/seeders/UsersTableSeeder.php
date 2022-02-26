<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'test太郎',
            'number' => '1234',
            'password' => Hash::make('1234')
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test次郎',
            'number' => '5678',
            'password' => Hash::make('5678')
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test三郎',
            'number' => '9012',
            'password' => Hash::make('9012')
        ];
        DB::table('users')->insert($param);
    }
}
