<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AtteController extends Controller
{
    public function login()
    {
        return view('atte.login');
    }
    public function date()
    {
        $attendances = Attendance::latest()->get();;
        return view('atte.date', compact('attendances'));
    }
    public function stamp()
    {
        if (Auth::check()) {
            return view('atte.stamp');
        }else{
            return view('atte.login');
            }
    }
    public function start_edit($id){
        return view('atte.stamp');
    }
    public function start_time(Request $request)
    {
        $user = Auth::user();

        // 出勤打刻は１日一回まで
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();
         if ($attendance) {
            $attendanceStartTime = new Carbon($attendance->start_time);
            $attendanceDay = $attendanceStartTime->startOfDay();
        }
        $newAttendanceDay = Carbon::today();

        // ２回目の出勤打刻時にエラーを表示
        if (($attendanceStartTime == $newAttendanceDay) && (empty($attendance->end_time))){
            \Session::flash('start_error', 'すでに出勤打刻がされています');
            return redirect()->back();
        }

        // 勤務開始を押したら新しくデータが作られる
        Attendance::create([
            'user_id' => $request->user_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'lest_start_time' => $request->lest_start_time,
            'lest_end_time' => $request->lest_end_time,
        ]);
        \Session::flash('start_msg', '出勤打刻が完了しました');
        return redirect()->back();
    }
    public function end_edit($id){
        return view('atte.stamp');
    }
   public function end_time(Request $request, $id)
    {
        $user = Auth::user();
        $param = [
            'end_time' => $request->end_time
        ];
        if( !empty($attendance->end_time)) {
            \Session::flash('end_error', '既に退勤の打刻がされているか、出勤打刻されていません');
            return redirect()->back();
        }
        $end_time = Attendance::where('user_id', $user->id)->latest()->first()->update($param);
        \Session::flash('end_msg', 'お疲れ様でした');
        return redirect()->back();
    }
    public function lest_start_edit($id){
        return view('atte.stamp');
    }
    public function lest_start_time(Request $request, $id)
    {
        $user = Auth::user();
        $param = [
            'lest_start_time' => $request->lest_start_time
        ];
        $lest_start_time = Attendance::where('user_id', $user->id)->latest()->first()->update($param);
        return redirect()->back();
    }
    public function lest_end_edit($id){
        return view('atte.stamp');
    }
    public function lest_end_time(Request $request, $id)
    {
        $user = Auth::user();
        $param = [
            'lest_end_time' => $request->lest_end_time
        ];
        $lest_end_time = Attendance::where('user_id', $user->id)->latest()->first()->update($param);
        return redirect()->back();
    }
}
