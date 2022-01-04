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
            'start_time' => '2022/01/01 10:00:00',
            'end_time' => '2022/01/01 20:00:00'
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 2,
            'start_time' => '2022/01/01 10:00:00',
            'end_time' => '2022/01/01 20:00:00'
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 3,
            'start_time' => '2022/01/01 10:00:00',
            'end_time' => '2022/01/01 20:00:00'
        ];
        DB::table('attendances')->insert($param);
    }
}
