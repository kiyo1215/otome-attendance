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
            'rest_id' => 1,
            'start_time' => '10:00:00',
            'end_time' => '20:00:00',
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 2,
            'rest_id' => 2,
            'start_time' => '10:00:00',
            'end_time' => '20:00:00',
            
        ];
        DB::table('attendances')->insert($param);
        $param = [
            'user_id' => 3,
            'rest_id' => 3,
            'start_time' => '10:00:00',
            'end_time' => '20:00:00',
        ];
        DB::table('attendances')->insert($param);
    }
}
