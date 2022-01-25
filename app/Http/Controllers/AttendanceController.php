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
    public function login()
    {

        return view('atte.login');
    }
    public function index()
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if (Auth::check()) {
            return view('atte.stamp');
        }else{
            return view('atte.login');
            }
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
    public function start_edit($id){
        return view('atte.stamp');
    }
    public function start_time(Request $request,$id)
    {
        $user = Auth::user();

        // 出勤打刻は１日一回まで
        // $attendance = Attendance::where('user_id', $user->id)->latest()->first();
        //  if ($attendance) {
        //     $attendanceStartTime = new Carbon($attendance->start_time);
        //     $attendanceDay = $attendanceStartTime->startOfDay();
        // }
        // $newAttendanceDay = Carbon::today();

        // ２回目の出勤打刻時にエラーを表示
        // if (($attendanceStartTime == $newAttendanceDay) && (empty($attendance->end_time))){
        //     \Session::flash('start_error', 'すでに出勤打刻がされています');
        //     return redirect()->back();
        // }

        // 勤務開始を押したら新しくデータが作られる
        Attendance::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time
        ]);
        
        \Session::flash('start_msg', '勤務を開始しました');
        return redirect()->back();
    }
    public function end_edit($id){
        return view('atte.stamp');
    }
   public function end_time(Request $request, $id)
    {
        $user = Auth::user();
        // 退勤したあとは退勤できない
        // if('$attendance->end_time' !== null) {
        //     \Session::flash('end_error', '既に退勤の打刻がされています');
        //     return redirect()->back();
        // }
        // if(!empty($attendance->end_time)) {
        //     \Session::flash('end_error', '既に退勤の打刻がされています');
        //     return redirect()->back();
        // }

        $param = [
            'end_time' => $request->end_time
        ];
        $end_time = Attendance::where('user_id', $user->id)->latest()->first()->update($param);
        \Session::flash('end_msg', 'お疲れ様でした');
        return redirect()->back();
    }
}
