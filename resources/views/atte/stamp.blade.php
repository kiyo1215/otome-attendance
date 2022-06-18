<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Otome Attendance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv=" X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
</head>

<body>
    <header>
        <h1>Otome Attendance</h1>
        <ul>
            <li>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout">ログアウト</button>
                </form>
            </li>
        </ul>
    </header>

    <main>
        <p class="time">{{$time}}</p>
        <h2>{{ Auth::user()->name }}さん、お疲れ様です！</h2>
        @if(session('message'))
        <div class="session">
            {{session('message')}}
        </div>
        @endif
        <div style="color: red">
        @if($errors->has('hub'))
        　　{{ $errors->first('hub') }}
        @endif
        </div>
        <div class="date-box">
            <form method="post" class="time-add" action="/attendance/start">
                @csrf
                <select name="hub">
                    <option value="">出勤店舗</option>
                    <option value="乙女ハウス">乙女ハウス</option>
                    <option value="あんじゅえーる">あんじゅえーる</option>
                    <option value="ふぁみーゆ">ふぁみーゆ</option>
                </select>
                <button type="submit" class="start_time">勤務開始</button>
            </form>
            <form method="post" class="time-add" action="/attendance/end">
                @csrf
                <button type="submit" class="end_time margin_top">勤務終了</button>
            </form>
        </div>

        <div class="date-box">
            <form method="post" class="time-add" action="/rest/start">
                @csrf
                <button type="submit" class="rest_start_time">休憩開始</button>
            </form>
            <form method="post" class="time-add" action="/rest/end">
                @csrf
                <button type="submit" class="rest_end_time">休憩終了</button>
            </form>
        </div>
    </main>
</body>

</html>