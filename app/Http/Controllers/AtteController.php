<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;


class AtteController extends Controller
{
    public function login()
    {
        return view('atte.login');
    }
    // public function showDate(){
    //     return view('atte.date');
    // }
    public function date()
    {
    //    $users = User::all();
        $attendances = Attendance::all();
        // $start_time = Attendance::select('start_time');
        // $end_time = Attendance::select('end_time');
        return view('atte.date', compact('attendances'));
    }
    public function stamp()
    {
        return view('atte.stamp');
    }
}
