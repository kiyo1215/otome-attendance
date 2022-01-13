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
            $start_time_carbon = \Carbon\Carbon::parse($attendance->start_time);
            $end_time_carbon = \Carbon\Carbon::parse($attendance->end_time);
            // $start_time = strtotime($attendance->start_time);
            // dd($start_time);
            // $end_time = strtotime($attendance->end_time);
            // $diff = $end_time - $start_time + strtotime("01:00:00");
            // dd($end_time);
            // $diff = strtotime($end_time_carbon) - strtotime($start_time_carbon);
            $diff = \Carbon\Carbon::parse($attendance->end_time)->diff(\Carbon\Carbon::parse($attendance->start_time));
            // dd($diff);
            // dd($diff / 60);
            // $diffTime = date("H:i:s", $diff);
            // $diffTime = date("H:i:s", $diff / 60);
            // dd($diffTime);




            $lest_start_time = strtotime($attendance->lest_start_time);
            $lest_end_time = strtotime( $attendance->lest_end_time);
            $lest_diff = ($lest_end_time - $lest_start_time) - 32400;
            $lest_diffTime = date("H:i:s", $lest_diff);
       ?>
     <tr>
       <td>{{ $attendance->user->name }}</td>
       <td>{{ $attendance->start_time }}</td>
       <td>{{ $attendance->end_time }}</td>
       <td>
        <?php
          echo $lest_diffTime;
          ?>
        </td>
      <td>
        <?php
        // $diffTime = strtotime($diffTime);
        // // dd($diffTime);
        // $lest_diffTime = strtotime($lest_diffTime);
        //  $work_diffTime = ($diffTime - $lest_diffTime) - 32400;
        //  $workTime = date("H:i:s", $work_diffTime);
        //  echo $workTime;
         echo date("H:i:s", $diff);
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