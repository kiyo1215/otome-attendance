<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $atte_start_time = null;
        $atte_end_time = null;
        $rest_start_time = null;
        $rest_end_time = null;

        //自分の本日の勤怠があるかのチェック、dateとuser_idで絞り込み
        $attendance = Attendance::where('user_id', Auth::id())->where('date', Carbon::today())->first();
        if (empty($attendance)) {
            return view('atte.stamp', compact('atte_start_time', 'atte_end_time', 'rest_start_time', 'rest_end_time'));
        }
        //勤怠がある場合は、スタートタイムとエンドタイムのチェック
        if (!empty($attendance)) {
            $atte_start_time = $attendance->start_time;
            $atte_end_time = $attendance->end_time;
        }
        //自分の本日の休憩があるかのチェック、attendance_idで絞り込み(リレーションで取得)
        $rest = Rest::where('attendance_id', $attendance->id)->latest()->first();
        if (empty($rest)) {
            return view('atte.stamp', compact('atte_start_time', 'atte_end_time', 'rest_start_time', 'rest_end_time'));
        }
        //休憩がある場合は、スタートタイムとエンドタイムのチェック
        if (!empty($rest)) {
            $rest_start_time = $rest->start_time;
            $rest_end_time = $rest->end_time;
        };
        //それらの情報を画面に受け渡す
        return view('atte.stamp', compact('atte_start_time', 'atte_end_time', 'rest_start_time', 'rest_end_time'));
    }

    public function date()
    {
        $date = Carbon::today()->format('Y-m-d');
        
        $rests = Rest::latest()->Paginate(5);
        $all_rests = DB::table('rests')
                ->select('attendance_id')
                ->selectRaw('SUM(end_time - start_time) AS all_time')
                ->groupBy('attendance_id')
                ->latest('attendance_id')
                ->get();
        return view('atte.date', compact('date', 'rests', 'all_rests'));
    }
    public function seach(Request $request)
    {
        Auth::check();
        $date = Carbon::today()->format("Y-m-d");
        $today = $request->input('today');
        $day = $request->input('date');

        if ($day == "next") {
            $date = date("Y-m-d", strtotime($today . "+1 day"));
        } else if ($day == "back") {
            $date = date("Y-m-d", strtotime($today . "-1 day"));
        }

        return back(compact('date'));
    }

    public function start()
    {
        // 勤務開始を押したら新しくデータが作られる
        Attendance::create([
            'user_id' => Auth::id(),
            'date' => Carbon::now()->format('Y-m-d'),
            'start_time' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('start_msg', '勤務を開始しました');
    }

    public function end()
    {
        $attendance = Attendance::where('user_id', Auth::id())->where('date', Carbon::today())->first();
        $rest = Rest::where('attendance_id', $attendance->id)->first();
        // dd($rest);
        if(empty($rest)){
            $param = [
                'end_time' => Carbon::now()->format('H:i:s')
            ];
            Attendance::where('user_id', Auth::id())->latest()->first()->update($param);
            Rest::create([
                'user_id' => Auth::id(),
                'attendance_id' => $attendance->id,
                'start_time' => '00:00:00',
                'end_time' => '00:00:00',
            ]);
        } else {
            $param = [
                'end_time' => Carbon::now()->format('H:i:s'),
            ];
            Attendance::where('user_id', Auth::id())->latest()->first()->update($param);
        }

        return back()->with('end_msg', 'お疲れ様でした');
    }
}
