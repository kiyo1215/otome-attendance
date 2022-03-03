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
        $attendances = Attendance::latest()->paginate(6);
        return view('management.date', compact('users', 'attendances'));
    }
    public function search(Request $request)
    {
        $users = User::all();
        $today = new Carbon('today');

        if($request->belong === null){
        if ($request->user_id !== null && $request->date_start === null && $request->date_end === null) {
            $attendances = Attendance::where('user_id', $request->user_id)->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
            $attendances = Attendance::wherebetween('date', [$request->date_start, $today])->latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end !== null) {
            $attendances = Attendance::where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $request->date_end])->latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end === null) {
            $attendances = Attendance::where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $today])->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
            $attendances = Attendance::wherebetween('date', [$request->date_start, $request->date_end])->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
            $attendances = Attendance::latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start === null && $request->date_end !== null) {
            $attendances = Attendance::where('user_id', $request->user_id)->where('date', '<=', $request->date_end)->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
            $attendances = Attendance::where('date', '<=', $request->date_end)->latest()->paginate(6);
        }
    }

        if($request->belong !== null){
        if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
            $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                    $query->where('belong', $request->belong);
                })->wherebetween('date', [$request->date_start, $today])->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
            $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                    $query->where('belong', $request->belong);
                })->wherebetween('date', [$request->date_start, $request->date_end])->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
            $attendances = Attendance::whereHas('user', function($query) use ($request){
                $query->where('belong', $request->belong);
                })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
            $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                    $query->where('belong', $request->belong);
                })->where('date', '<=', $request->date_end)->latest()->paginate(6);
        }
    }

        return view('management.reward', compact('attendances', 'users'));
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
        $attendances = Attendance::latest()->paginate(6);
        return view('management.reward', compact('users', 'attendances'));
    }
    public function showCsv(){
        $users = User::all();
        return view('management.csv', compact('users'));
    }
    public function csv(Request $request)
    {
        $headers = [ //ヘッダー情報
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=csvexport.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($request) {
            $createCsvFile = fopen('php://output', 'w'); //ファイル作成
            $today = new Carbon('today');
            $columns = [ //1行目の情報
                    '名前',
                    '所属',
                    '日付',
                    '曜日',
                    '勤務開始時間',
                    '勤務終了時間',
                ];
            mb_convert_variables('SJIS-win', 'UTF-8', $columns); //文字化け対策

            fputcsv($createCsvFile, $columns); //1行目の情報を追記

            if ($request->belong === null) {
                if ($request->user_id !== null && $request->date_start === null && $request->date_end === null) {
                    $attendances = Attendance::where('user_id', $request->user_id)->latest()->get();
                }
                if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
                    $attendances = Attendance::wherebetween('date', [$request->date_start, $today])->latest()->get();
                }
                if ($request->user_id !== null && $request->date_start !== null && $request->date_end !== null) {
                    $attendances = Attendance::where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $request->date_end])->latest()->get();
                }
                if ($request->user_id !== null && $request->date_start !== null && $request->date_end === null) {
                    $attendances = Attendance::where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $today])->latest()->get();
                }
                if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
                    $attendances = Attendance::wherebetween('date', [$request->date_start, $request->date_end])->latest()->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
                    $attendances = Attendance::latest()->get();
                }
                if ($request->user_id !== null && $request->date_start === null && $request->date_end !== null) {
                    $attendances = Attendance::where('user_id', $request->user_id)->where('date', '<=', $request->date_end)->latest()->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
                    $attendances = Attendance::where('date', '<=', $request->date_end)->latest()->get();
                }
            }  //データベースからデータ取得
            if ($request->belong !== null) {
                if ($request->user_id === null && $request->date_start !== null && $request->date_end === null
                ) {
                    $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->wherebetween('date', [$request->date_start, $today])->latest()->get();
                }
                if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null
                ) {
                    $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->wherebetween('date', [$request->date_start, $request->date_end])->latest()->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end === null
                ) {
                    $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->latest()->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end !== null
                ) {
                    $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->where('date', '<=', $request->date_end)->latest()->get();
                }
            }

            foreach ($attendances as $row) {  //データを1行ずつ回す
                $csv = [
                    $row->user->name,  //オブジェクトなので -> で取得
                    $row->user->belong,  //オブジェクトなので -> で取得
                    $row->date,
                    $row->week,
                    $row->start_time,
                    $row->end_time,
                ];
            mb_convert_variables('SJIS-win', 'UTF-8', $csv); //文字化け対策

            fputcsv($createCsvFile, $csv); //ファイルに追記する
    }
        fclose($createCsvFile); //ファイル閉じる
};
        return response()->stream($callback, 200, $headers); //ここで実行
    }
}
