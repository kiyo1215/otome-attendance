<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Restcontroller extends Controller
{
    public function start_edit($id){
        
        return view('atte.stamp');
    }
    public function start_time(Request $request, $id)
    {
        $user = Auth::user();
        $attendance = Attendance::where('user_id', Auth::id())->where('date', Carbon::today())->first();
        Rest::create([
            'user_id' => Auth::id(),
            'attendance_id' => $attendance->id,
            'rest_start_time' => $start_time,
        ]);
        // $param = [
        //     'rest_start_time' => $request->rest_start_time,
        //     'rest_end_time' => $request->rest_end_time
        // ];
        // $rest_start_time = Rest::where('user_id', $user->id)->latest()->first()->update($param);
        \Session::flash('rest_start', '休憩を開始しました');
        return redirect()->back();
    }
    public function end_edit($id){
        return view('atte.stamp');
    }
    public function end_time(Request $request, $id)
    {
        $user = Auth::user();
        // if(!empty($attendance->lest_end_time)) {
        //     \Session::flash('lest_end_error', '既に休憩終了の打刻がされています');
        //     return redirect()->back();
        // }
        $param = [
            'rest_end_time' => $request->lest_end_time
        ];
        $rest_end_time = Attendance::where('user_id', $user->id)->latest()->first()->update($param);
        \Session::flash('rest_end', '休憩を終了しました');
        return redirect()->back();
    }
}
