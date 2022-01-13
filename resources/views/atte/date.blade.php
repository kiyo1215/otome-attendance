<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Site</title>
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/date.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv=" X-UA-Compatible" content="ie=edge">
</head>

<body>
  <header>
    <h1>Atte</h1>
    <ul>
      <li><a href="#">ホーム</a></li>
      <li><a href="#">日付一覧</a></li>
      <li>
       <form method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
      </li>
    </ul>
  </header>
  <main>
   <table>
     <tr>
       <th>名前</th>
       <th>勤務開始</th>
       <th>勤務終了</th>
       <th>休憩時間</th>
       <th>勤務時間</th>
     </tr>
     @foreach($attendances as $attendance)
       <?php
            $start_time = new DateTime($attendance->start_time);
            $end_time = new DateTime($attendance->end_time);
            $diff = $end_time->diff($start_time);

            $lest_start_time = new DateTime($attendance->lest_start_time);
            $lest_end_time = new DateTime($attendance->lest_end_time);
            $lest_diff = $lest_end_time->diff($lest_start_time);

            $work_time = new DateTime($diff->format('%H:%I:%S'));
            $lest_time = new DateTime($lest_diff->format('%H:%I:%S'));
            $diff_time = $work_time->diff($lest_time);
       ?>
     <tr>
       <td>{{ $attendance->user->name }}</td>
       <td>{{ $attendance->start_time }}</td>
       <td>{{ $attendance->end_time }}</td>
       <td>
        <?php
          echo $lest_diff->format('%H:%I:%S')
          ?>
        </td>
      <td>
        <?php
         echo $diff_time->format('%H:%I:%S')
        ?>
      </td>
     </tr>
     @endforeach
   </table>
  </main>
  <footer>
    <p>Atte,inc.</p>
  </footer>
</body>

</html>