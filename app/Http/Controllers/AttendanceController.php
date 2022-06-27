<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HubRequest;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
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
        $time = Carbon::now()-> format('Y年m月d日 H:i:s');
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
        return view('atte.stamp', compact('atte_start_time', 'atte_end_time', 'rest_start_time', 'rest_end_time', 'time'));
    }

    public function start(HubRequest $request)
    {
        // 勤務開始を押したら新しくデータが作られる
        Attendance::create([
            'user_id' => Auth::id(),
            'date' => Carbon::now()->format('Y-m-d'),
            'week' => Carbon::now()->isoFormat('ddd'),
            'hub' => $request->hub,
            'start_time' => Carbon::now()->format('H:i:s'),
            'end_time' => Carbon::now()->format('H:i:s'),
        ]);
        
        return back()->with('message', '勤務を開始しました');
    }

    public function end()
    {
        $daybefore = new Carbon('yesterday');
        $now = Carbon::now()->format('H:i:s');
        $today = Carbon::today();

        if($now >= '00:00:00' && $now <= '11:00:00'){
            $attendance = Attendance::where('user_id', Auth::id())->where('date', $daybefore->format('Y-m-d'))->first();
            $rest = Rest::where('attendance_id', $attendance->id)->first();
            if (empty($rest)) {
                if ($attendance === null) {
                    return back()->with('message', '出勤打刻がありません');
                } else {
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
                    return back()->with('message', '今日もありがとう、大好きだよ');
                }
            } else {
                $param = [
                    'end_time' => Carbon::now()->format('H:i:s'),
                ];
                Attendance::where('user_id', Auth::id())->latest()->first()->update($param);
                return back()->with('message', '今日もありがとう、大好きだよ');
            }
        } else {
            $attendance = Attendance::where('user_id', Auth::id())->where('date', $today)->first();
            // $rest = Rest::where('attendance_id', $attendance->id)->first();
                if($attendance === null){
                    return back()->with('message', '出勤打刻がありません');
                }else{
                    $param = [
                        'end_time' => Carbon::now()->format('H:i:s')
                    ];
                    Attendance::where('user_id', Auth::id())->latest()->first()->update($param);
                    // Rest::create([
                    //     'user_id' => Auth::id(),
                    //     'attendance_id' => $attendance->id,
                    //     'start_time' => '00:00:00',
                    //     'end_time' => '00:00:00',
                    //     ]);
                        return back()->with('message', '今日もありがとう、大好きだよ');
                    }
    }
}

    public function rest_start()
    {
        $attendance = Attendance::where('user_id', Auth::id())->where('date', Carbon::today())->first();
        Rest::create([
            'attendance_id' => $attendance->id,
            'start_time' => Carbon::now()->format("H:i:s")
        ]);
        return back()->with('message', '休憩を開始しました');
    }
    public function rest_end()
    {
        $param = [
            'end_time' => Carbon::now()->format("H:i:s")
        ];
        $daybefore = new Carbon('yesterday');
        $now = Carbon::now()->format('H:i:s');
        $today = Carbon::today()->format('Y-m-d');
        if ($now >= '00:00:00' && $now <= '11:00:00') {
            $attendance = Attendance::where('user_id', Auth::id())->where('date', $daybefore->format('Y-m-d'))->first();
        }
        $attendance = Attendance::where('user_id', Auth::id())->where('date', $today)->first();
        Rest::where('attendance_id', $attendance->id)->latest()->first()->update($param);
        return back()->with('message', '休憩を終了しました');
    }
}
