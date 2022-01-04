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
            'email' => 'test1@test.com',
            'password' => Hash::make('test1234')
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test次郎',
            'email' => 'test2@test.com',
            'password' => Hash::make('test5678')
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'test三郎',
            'email' => 'test3@test.com',
            'password' => Hash::make('test9012')
        ];
        DB::table('users')->insert($param);
    }
}
