<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>My Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv=" X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
</head>

<body>
    <header>
        <h1>Atte</h1>
        <ul>
            <li>
                <a href="{{ route('index') }}">ホーム</a>
            </li>
            <li>
                <a href="{{ route('date') }}">日付一覧</a>
            </li>
            <li>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout">ログアウト</button>
                </form>
            </li>
        </ul>
    </header>

    <main>
        <h2>{{ Auth::user()->name }}さんお疲れ様です！</h2>
        @if(session('message'))
          <div class="session">
            {{session('massage')}}
          </div>
        @endif
        <div class="date-box">
            @if(!$atte_start_time)
                <form method="post" class="time-add" action="/attendance/start">
                    @csrf
                    <button type="submit" class="start_time">勤務開始</button>
                </form>
            @else
                <button type="button" class="none-button">勤務開始</button>
            @endif

            @if($atte_start_time && !$atte_end_time)
                <form method="post" class="time-add" action="/attendance/end">
                    @csrf
                    <button type="submit" class="end_time">勤務終了</button>
                </form>
            @else
                <button type="button" class="none-button">勤務終了</button>
            @endif
        </div>

        <div class="date-box">
            @if(($atte_start_time && !$atte_end_time && !$rest_start_time) || ($atte_start_time && !$atte_end_time && $rest_end_time))
                <form method="post" class="time-add" action="/rest/start">
                    @csrf
                    <button type="submit" class="rest_start_time">休憩開始</button>
                </form>
            @else
                <button type="button" class="none-button">休憩開始</button>
            @endif

            @if($atte_start_time && !$atte_end_time && $rest_start_time && !$rest_end_time)
                <form method="post" class="time-add" action="/rest/end">
                    @csrf
                    <button type="submit" class="rest_end_time">休憩終了</button>
                </form>
            @else
                <button type="button" class="none-button">休憩終了</button>
            @endif
        </div>
    </main>

    <footer>
        <p>Atte,inc.</p>
    </footer>
</body>

</html>
