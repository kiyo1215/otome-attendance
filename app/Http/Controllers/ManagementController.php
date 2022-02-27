<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;

class ManagementController extends Controller
{
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
}
