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
        $attendances = Attendance::all();
        foreach($attendances as $attendance){
            $dt1 = new Carbon($attendance->start_time);
            // dd($dt1);
            $dt2 = new Carbon($attendance->end_time);
            $diff = strtotime($dt2) - strtotime($dt1);
            // dd($diff);
        }
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
    public function start_time(Request $request, $id)
    {
        $param = [
            'start_time' => $request->start_time
        ];
        DB::table('attendances')->where('id', $request->id)->update($param);
        return redirect()->back();
    }
    public function end_edit($id){
        return view('atte.stamp');
    }
   public function end_time(Request $request, $id)
    {
        $param = [
            'end_time' => $request->end_time
        ];
        DB::table('attendances')->where('id', $request->id)->update($param);
        return redirect()->back();
    }
    public function lest_start_edit($id){
        return view('atte.stamp');
    }
    public function lest_start_time(Request $request, $id)
    {
        $param = [
            'lest_start_time' => $request->lest_start_time
        ];
        DB::table('attendances')->where('id', $request->id)->update($param);
        return redirect()->back();
    }
    public function lest_end_edit($id){
        return view('atte.stamp');
    }
    public function lest_end_time(Request $request, $id)
    {
        $param = [
            'lest_end_time' => $request->lest_end_time
        ];
        DB::table('attendances')->where('id', $request->id)->update($param);
        return redirect()->back();
    }
}
