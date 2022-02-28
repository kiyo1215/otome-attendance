<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
use Carbon\Carbon;

class ManagementController extends Controller
{
    public function home(){
        return view('management.home');
    }
    public function date()
    {
        $users = User::all();
        $attendances = Attendance::latest()->paginate(7);
        return view('management.date', compact('users', 'attendances'));
    }
    public function search(Request $request)
    {
        $users = User::all();
        $today = new Carbon('today');

        if ($request->user_id !== null && $request->date_start === null && $request->date_end === null) {
            $attendances = Attendance::where('user_id', $request->user_id)->latest()->paginate(7);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
            $attendances = Attendance::wherebetween('date', [$request->date_start, $today])->latest()->paginate(7);
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end !== null) {
            $attendances = Attendance::where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $request->date_end])->latest()->paginate(7);
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end === null) {
            $attendances = Attendance::where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $today])->latest()->paginate(7);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
            $attendances = Attendance::wherebetween('date', [$request->date_start, $request->date_end])->latest()->paginate(7);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
            $attendances = Attendance::wherebetween('date', [$request->date_start, $request->date_end])->latest()->paginate(7);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
            $attendances = Attendance::latest()->paginate(7);
        }
        if ($request->user_id !== null && $request->date_start === null && $request->date_end !== null) {
            $attendances = Attendance::where('user_id', $request->user_id)->where('date', '<=', $request->date_end)->latest()->paginate(7);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
            $attendances = Attendance::where('date', '<=', $request->date_end)->latest()->paginate(7);
        }

        return view('atte.date', compact('attendances', 'users'));
    }
    public function showAtte()
    {
        $attendances = Attendance::latest()->paginate(7);
        $users = User::all();
        return view('management.atte', compact('attendances', 'users'));
    }
    public function showRest()
    {
        $rests = Rest::latest()->paginate(7);
        $users = User::all();
        return view('management.rest', compact('rests', 'users'));
    }
    public function changeAtte(Request $request)
    {
        $users = User::all();
        $atte = [
            'date' => $request->date,
            'start_time' => $request->atte_start_time,
            'end_time' => $request->atte_end_time,
        ];
        Attendance::where('id', $request->id)->update($atte);
        $attendances = Attendance::latest()->paginate(7);
        return view('atte.date', compact('users', 'attendances'));
    }
    public function changeRest(Request $request)
    {
        $users = User::all();
        $rest = [
            'start_time' => $request->rest_start_time,
            'end_time' => $request->rest_end_time,
        ];
        Rest::where('id', $request->id)->update($rest);
        $attendances = Attendance::latest()->paginate(7);
        return view('atte.date', compact('users', 'attendances'));
    }
    public function showReward()
    {
        $users = User::all();
        $attendances = Attendance::latest()->paginate(7);
        return view('management.reward', compact('users', 'attendances'));
    }
}
