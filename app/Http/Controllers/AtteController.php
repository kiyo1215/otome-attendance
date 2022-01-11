<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AtteController extends Controller
{
    public function login()
    {
        return view('atte.login');
    }
    public function date()
    {
        $attendances = Attendance::all();
        return view('atte.date', compact('attendances'));
    }
    public function stamp()
    {
        return view('atte.stamp');
    }
    public function edit($id)
    {
       $attendance = Attendance::findOrFail($id);
        dd($attendance);
    //    return view('atte.stamp');
    }
    public function start_time(Request $request, $id)
    {
        $param = [
            'start_time' => $request->start_time
        ];
        // dd($param);
        // // DB::table('attendances')->where('id', $request->id)->update($param);
        // // return view('atte.date');

        // $attendance = Attendance::findOrFail($id);
        // $attendance->start_time = $request->start_time;
        // $attendance->save();
        // return view('atte.date');
    }
    public function end_time(equest $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->end_time = $request->end_time;
        $attendance->save();
        return redurect();
    }
    public function lest_start_time(equest $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->lest_start_time = $request->lest_start_time;
        $attendance->save();
        return redurect();
    }
    public function lest_end_time(equest $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->lest_end_time = $request->lest_end_time;
        $attendance->save();
        return redurect();
    }
}
