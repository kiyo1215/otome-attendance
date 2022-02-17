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
        $date = Carbon::now()->format('Y-m-d');
        $attendances = Attendance::whereDate('date', $date)->paginate(5);
        
        return view('atte.date', compact('date', 'attendances'));
    }
    public function search(Request $request)
    {
        $date = Carbon::parse()->format('Y-m-d');
        if($request->date === 'back'){
            $date = Carbon::parse('-1 day')->format('Y-m-d');
        }elseif($request->date === 'next'){
            $date = Carbon::parse('+1 day')->format('Y-m-d');
        }
        $attendances = DB::table('attendances')->whereDate('date', $date)->Paginate(5);

        return view('atte.date', compact('date', 'attendances'));
    }

    public function start()
    {
        // 勤務開始を押したら新しくデータが作られる
        Attendance::create([
            'user_id' => Auth::id(),
            'date' => Carbon::now()->format('Y-m-d'),
            'start_time' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('massage', '勤務を開始しました');
    }

    public function end()
    {
        $attendance = Attendance::where('user_id', Auth::id())->where('date', Carbon::today())->first();
        $rest = Rest::where('attendance_id', $attendance->id)->first();
        
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

        return back()->with('massage', 'お疲れ様でした');
    }
}
