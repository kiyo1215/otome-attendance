<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\auto_time;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
        $user = Auth::user();
        if(empty(Attendance::select('end_time'))){
            $param = [
                'end_time' => Carbon::now()
                ];
            Attendance::where('user_id', $user->id)->latest()->first()->update($param);
            };
            
        })->daily('18:59');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
