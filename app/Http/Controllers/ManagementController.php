<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ManagementController extends Controller
{
    public function management(){
        return view('management.management');
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
    public function show_atte()
    {
        $attendances = Attendance::latest()->paginate(6);
        $users = User::all();
        return view('management.atte', compact('attendances', 'users'));
    }
    public function show_rest()
    {
        $rests = Rest::latest()->paginate(6);
        $users = User::all();
        return view('management.rest', compact('rests', 'users'));
    }
    public function change_atte(Request $request)
    {
        $users = User::all();
        $atte = [
            'date' => $request->date,
            'start_time' => $request->atte_start_time,
            'end_time' => $request->atte_end_time,
        ];
        Attendance::where('id', $request->id)->update($atte);
        $attendances = Attendance::latest()->paginate(7);
        // return view('management.atte', compact('users', 'attendances'));
        return back()->with('msg', '編集しました');
    }
    public function atte_search(Request $request)
    {
        $users = User::all();
        $today = new Carbon('today');

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

        return view('management.atte', compact('attendances', 'users'));
    }
    public function change_rest(Request $request)
    {
        $users = User::all();
        $rest = [
            'start_time' => $request->rest_start_time,
            'end_time' => $request->rest_end_time,
        ];
        Rest::where('id', $request->id)->update($rest);
        $attendances = Attendance::latest()->paginate(7);
        return view('management.rest', compact('users', 'attendances'));
    }
    public function search_rest(Request $request)
    {
        $users = User::all();
        $today = new Carbon('today');

        if($request->belong === null){
        if ($request->user_id !== null && $request->date_start === null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function($query) use ($request){
                $query->where('user_id', $request->user_id);
            })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->wherebetween('date', [$request->date_start, $today]);
            })->latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $request->date_end]);
            })->latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $today]);
            })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->wherebetween('date', [$request->date_start, $request->date_end]);
            })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
            $rests = Rest::latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start === null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->where('user_id', $request->user_id)->where('date', '<=', $request->date_end);
            })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->where('date', '<=', $request->date_end);
            })->latest()->paginate(6);
        }
    }
    if($request->belong !== null){
        if ($request->user_id !== null && $request->date_start === null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function($query) use ($request){
                $query->where('user_id', $request->user_id)->whereHas('user', function($query2) use ($request){
                    $query2->where('belong', $request->belong);
                });
            })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->wherebetween('date', [$request->date_start, $today])->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $request->date_end])->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $today])->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->wherebetween('date', [$request->date_start, $request->date_end])->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                });
                    })->latest()->paginate(6);
        }
        if ($request->user_id !== null && $request->date_start === null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->where('user_id', $request->user_id)->where('date', '<=', $request->date_end)->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->latest()->paginate(6);
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->where('date', '<=', $request->date_end)->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->latest()->paginate(6);
        }
    }
        return view('management.rest', compact('rests', 'users'));
    }

    public function show_reward()
    {
        $users = User::all();
        $attendances = Attendance::latest()->paginate(6);
        return view('management.reward', compact('users', 'attendances'));
    }
    public function atte_delete($id){
        Rest::where('attendance_id', $id)->delete();
        Attendance::where('id', $id)->delete();
        
        return back()->with('msg', '削除しました');
    }
    // Rest::whereHas('attendance', function($query) use ($request) {
    //         $query->where('user_id', $request->id);
    //     })->delete();
    //     Attendance::where('user_id', $request->id)->delete();
    //     User::where('id', $request->id)->delete();
    //     return back()->with('delete', '卒業しました');
    public function show_csv(){
        $users = User::all();
        return view('management.csv', compact('users'));
    }
    public function atte_csv(Request $request)
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
                    '出勤店舗',
                    '勤務開始時間',
                    '勤務終了時間',
                ];
            mb_convert_variables('SJIS-win', 'UTF-8', $columns); //文字化け対策

            fputcsv($createCsvFile, $columns); //1行目の情報を追記

            if ($request->belong === null) {
                if ($request->user_id !== null && $request->date_start === null && $request->date_end === null) {
                    $attendances = Attendance::where('user_id', $request->user_id)->get();
                }
                if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
                    $attendances = Attendance::wherebetween('date', [$request->date_start, $today])->get();
                }
                if ($request->user_id !== null && $request->date_start !== null && $request->date_end !== null) {
                    $attendances = Attendance::where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $request->date_end])->get();
                }
                if ($request->user_id !== null && $request->date_start !== null && $request->date_end === null) {
                    $attendances = Attendance::where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $today])->get();
                }
                if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
                    $attendances = Attendance::wherebetween('date', [$request->date_start, $request->date_end])->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
                    $attendances = Attendance::all();
                }
                if ($request->user_id !== null && $request->date_start === null && $request->date_end !== null) {
                    $attendances = Attendance::where('user_id', $request->user_id)->where('date', '<=', $request->date_end)->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
                    $attendances = Attendance::where('date', '<=', $request->date_end)->get();
                }
            }  //データベースからデータ取得
            if ($request->belong !== null) {
                if ($request->user_id === null && $request->date_start !== null && $request->date_end === null
                ) {
                    $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->wherebetween('date', [$request->date_start, $today])->get();
                }
                if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null
                ) {
                    $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->wherebetween('date', [$request->date_start, $request->date_end])->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end === null
                ) {
                    $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end !== null
                ) {
                    $attendances = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->where('date', '<=', $request->date_end)->get();
                }
            }
            foreach ($attendances as $row) {  //データを1行ずつ回す
                $csv = [
                    $row->user->name,
                    $row->user->belong,
                    $row->date,
                    $row->week,
                    $row->hub,
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
    public function rest_csv(Request $request){
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
                '休憩開始時間',
                '休憩終了時間',
            ];
            mb_convert_variables('SJIS-win', 'UTF-8', $columns); //文字化け対策

            fputcsv($createCsvFile, $columns); //1行目の情報を追記

             if ($request->belong === null) {
                if ($request->user_id !== null && $request->date_start === null && $request->date_end === null) {
                    $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                        $query->where('user_id', $request->user_id);
                    })->get();
                }
                if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
                    $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                        $query->wherebetween('date', [$request->date_start, $today]);
                    })->get();
                }
                if ($request->user_id !== null && $request->date_start !== null && $request->date_end !== null) {
                    $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                        $query->where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $request->date_end]);
                    })->get();
                }
                if ($request->user_id !== null && $request->date_start !== null && $request->date_end === null) {
                    $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                        $query->where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $today]);
                    })->get();
                }
                if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
                    $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                        $query->wherebetween('date', [$request->date_start, $request->date_end]);
                    })->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
                    $rests = Rest::all();
                }
                if ($request->user_id !== null && $request->date_start === null && $request->date_end !== null) {
                    $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                        $query->where('user_id', $request->user_id)->where('date', '<=', $request->date_end);
                    })->get();
                }
                if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
                    $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                        $query->where('date', '<=', $request->date_end);
                    })->get();
                }
            }  
            //データベースからデータ取得
            if($request->belong !== null){
                if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
                    $rests = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->wherebetween('date', [$request->date_start, $today])->get();
                }
                if (
                    $request->user_id === null && $request->date_start !== null && $request->date_end !== null
                ) {
                    $rests = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->wherebetween('date', [$request->date_start, $request->date_end])->get();
                }
                if (
                    $request->user_id === null && $request->date_start === null && $request->date_end === null
                ) {
                    $rests = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->get();
                }
                if (
                    $request->user_id === null && $request->date_start === null && $request->date_end !== null
                ) {
                    $rests = Attendance::whereHas('user', function ($query) use ($request) {
                        $query->where('belong', $request->belong);
                    })->where('date', '<=', $request->date_end)->get();
                }
            }
        if($request->belong !== null){
        if ($request->user_id !== null && $request->date_start === null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function($query) use ($request){
                $query->where('user_id', $request->user_id)->whereHas('user', function($query2) use ($request){
                    $query2->where('belong', $request->belong);
                });
            })->get();
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->wherebetween('date', [$request->date_start, $today])->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->get();
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $request->date_end])->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->get();
        }
        if ($request->user_id !== null && $request->date_start !== null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request, $today) {
                $query->where('user_id', $request->user_id)->wherebetween('date', [$request->date_start, $today])->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->get();
        }
        if ($request->user_id === null && $request->date_start !== null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->wherebetween('date', [$request->date_start, $request->date_end])->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->get();
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end === null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                });
                    })->get();
        }
        if ($request->user_id !== null && $request->date_start === null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->where('user_id', $request->user_id)->where('date', '<=', $request->date_end)->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->get();
        }
        if ($request->user_id === null && $request->date_start === null && $request->date_end !== null) {
            $rests = Rest::whereHas('attendance', function ($query) use ($request) {
                $query->where('date', '<=', $request->date_end)->whereHas('user', function ($query2) use ($request) {
                        $query2->where('belong', $request->belong);
                    });
            })->get();
        }
    }
            foreach ($rests as $row) {  //データを1行ずつ回す
                $csv = [
                    $row->attendance->user->name,
                    $row->attendance->user->belong,
                    $row->attendance->date,
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
    public function graduation(){
        $users = User::oldest('number')->paginate(10);
        return view('management.graduation', compact('users'));
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required',
            'belong' => 'required',
            'number' => 'required|unique:users|numeric|digits:4',
            'password' => 'required|numeric|digits:4',
        ]);
        User::create([
            'name' => $request->name,
            'belong' => $request->belong,
            'number' => $request->number,
            'password' => Hash::make($request->password),
        ]);
        return back()->with('create', '登録しました');
    }
    public function delete(Request $request){
        Rest::whereHas('attendance', function($query) use ($request) {
            $query->where('user_id', $request->id);
        })->delete();
        Attendance::where('user_id', $request->id)->delete();
        User::where('id', $request->id)->delete();
        return back()->with('delete', '卒業しました');
    }
    public function aaa(){
        $users = User::all();
        return view('management.aaa', compact('users'));
    }
    public function bbb(Request $request){
        $change = ['name' => $request->name];
        User::where('id', $request->id)->update($change);
        return back();
    }
}
