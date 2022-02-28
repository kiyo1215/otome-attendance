<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Site</title>
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/paginate.css')}}">
  <link rel="stylesheet" href="{{asset('css/date.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv=" X-UA-Compatible" content="ie=edge">
</head>

<body>
  <header>
    <h1>Otome Attendance Management</h1>
    <ul>
      <li><a href="{{ route('showAtte') }}">勤務時間編集</a></li>
      <li><a href="{{ route('showRest') }}">休憩時間編集</a></li>
      <li><a href="{{ route('showReward') }}">給与</a></li>
      <li>
        <form method="post" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout">ログアウト</button>
          　
        </form>
      </li>
    </ul>
  </header>
  <main>
    <div class="search">
      <form method="post" action="{{ route('search')}}">
        @csrf
        <div>名前
          <select name="user_id">
            <option value="">全員</option>
            @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="day">日付<input type="date" name="date_start">
          〜<input type="date" name="date_end"></div>
        <button type="submit">検索</button>
      </form>
    </div>
    <div class="info">
      <table class="attendance">
        <tr>
          <th>名前</th>
          <th>日付</th>
          <th>勤務開始</th>
          <th>勤務終了</th>
          <th>休憩時間</th>
          <th>勤務時間</th>
        </tr>
        @foreach($attendances as $attendance)
        <tr>
          <td>{{ $attendance->user->name }}</td>
          <td>{{ $attendance->date}}
          <td>{{ $attendance->start_time }}</td>
          <td>{{ $attendance->end_time }}</td>
          <td>
            @php
            $sum = 0;
            foreach($attendance->rests as $index => $rest){
            $start_time = new DateTime($rest->start_time);
            $end_time = new DateTime($rest->end_time);
            $interval = $start_time->diff($end_time);
            $sum = $sum + ($interval->h * 3600) + ($interval->i * 60) + $interval->s;

            if($index === count($attendance->rests) - 1){

            $hours = floor($sum / 3600);
            $minutes = floor(($sum / 60) % 60);
            $seconds = $sum % 60;
            $rest_time = (sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds));
            echo $rest_time;
            }
            }
            @endphp
          </td>
          <td>
            @php
            $rest_second = ($hours * 3600) + ($minutes * 60) + $seconds;

            $start_time = new DateTime($attendance->start_time);
            $end_time = new DateTime($attendance->end_time);
            $interval = $start_time->diff($end_time);
            $work_second = ($interval->h * 3600) + ($interval->i * 60) + $interval->s;

            $work_time = $work_second - $rest_second;

            $work_hours = floor($work_time / 3600);
            $work_minutes = floor(($work_time / 60) % 60);
            $work_seconds = $work_time % 60;
            echo (sprintf("%02d:%02d:%02d", $work_hours, $work_minutes, $work_seconds));
            @endphp
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    {{ $attendances->links() }}
  </main>
  <footer>
    <p>Atte,inc.</p>
  </footer>
</body>

</html>