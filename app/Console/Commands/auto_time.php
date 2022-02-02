<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class auto_time extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'end_time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '24時になったら退勤して翌日の出勤に切り替える';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = Auth::user();
        $param = [
            'end_time' => Carbon::now()
        ];
        $end_time = Attendance::where('user_id', $user->id)->latest()->first()->update($param);
    }
}
