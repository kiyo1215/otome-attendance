<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function index()
    {
        //自分の本日の勤怠があるかのチェック、dateとuser_idで絞り込み
        $attendance = Attendance::where('user_id', Auth::id())->where('date', Carbon::today())->first();
        //勤怠がある場合は、スタートタイムとエンドタイムのチェック
        if(!empty($attendance)){
            $start_time = $attendance->start_time;
            $end_time = $attendance->end_time;
        }
        //自分の本日の休憩があるかのチェック、attendance_idで絞り込み(リレーションで取得)
        $rests = Rest::where('user_id', Auth::id())->where('date', Carbon::today())->where('rest', $rest->attendance->id)->first();
        //休憩がある場合は、スタートタイムとエンドタイムのチェック
        if(!empty($rest)){
            $start_time = $rest->start_time;
            $end_time = $rest->end_time;
        };
        //それらの情報を画面に受け渡す
        return view('atte.stamp', compact('attendances','rests'));
    }

    public function date()
    {
        $attendances = Attendance::latest()->get();
        $rests = Rest::latest()->get();
        $items = Attendance::Paginate(5);
        $all_rests = DB::table('rests')
                ->select('attendance_id')
                ->selectRaw('SUM(end_time - start_time) AS all_time')
                ->groupBy('attendance_id')
                ->latest('attendance_id')
                ->get();
        return view('atte.date', compact('attendances', 'rests', 'items', 'all_rests'));
    }

    public function start(Request $request)
    {
        // 勤務開始を押したら新しくデータが作られる
        Attendance::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'start_time' => $request->start_time,
        ]);
        return back()->with('start_msg', '勤務を開始しました');
    }

   public function end(Request $request)
    {
        $param = [
            'end_time' => $request->end_time
        ];
        Attendance::where('user_id', Auth::id())->latest()->first()->update($param);
        return back()->with('end_msg', 'お疲れ様でした');
    }
}
