<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
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
            'date' => '2022/01/19',
            'week' => '水',
            'start_time' => '10:00:00',
            'end_time' => '20:00:00',
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 2,
            'date' => '2022/01/19',
            'week' => '水',
            'start_time' => '10:00:00',
            'end_time' => '05:00:00',
            
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 3,
            'date' => '2022/01/19',
            'week' => '水',
            'start_time' => '23:00:00',
            'end_time' => '05:00:00',
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => '2022/02/28',
            'week' => '月',
            'start_time' => '15:00:00',
            'end_time' => '24:00:00',
        ];
        DB::table('attendances')->insert($param);
    }
}
