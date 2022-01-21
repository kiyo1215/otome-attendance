<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'attendance_id' => 1,
            'start_time' => '15:00:00',
            'end_time' => '16:00:00',
        ];
        DB::table('rests')->insert($param);
        $param = [
            'user_id' => 2,
            'attendance_id' => 2,
            'start_time' => '15:00:00',
            'end_time' => '16:00:00',
            
        ];
        DB::table('rests')->insert($param);
        $param = [
            'user_id' => 3,
            'attendance_id' => 3,
            'start_time' => '15:00:00',
            'end_time' => '16:00:00',
        ];
        DB::table('rests')->insert($param);
    }
}
