<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestController extends Controller
{
    public function start()
    {
        $attendance = Attendance::where('user_id', Auth::id())->where('date', Carbon::today())->first();
        Rest::create([
            'attendance_id' => $attendance->id,
            'start_time' => Carbon::now()->format("H:i:s")
        ]);
        return back()->with('message', '休憩を開始しました');
    }
    public function end()
    {
        $param = [
            'end_time' => Carbon::now()->format("H:i:s")
        ];
        $attendance = Attendance::where('user_id', Auth::id())->where('date', Carbon::today())->first();
        $rest_end_time = Rest::where('attendance_id', $attendance->id)->latest()->first()->update($param);
        return back()->with('message', '休憩を終了しました');
    }
}
