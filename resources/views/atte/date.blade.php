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
      <li><a href="{{ route('stamp') }}">ホーム</a></li>
      <li><a href="{{ route('date') }}">日付一覧</a></li>
      <li>
       <form method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
      </li>
    </ul>
  </header>
  <main>
  {{ $items->links() }}
   <table>
     <tr>
       <th>名前</th>
       <th>勤務開始</th>
       <th>勤務終了</th>
       <th>休憩時間</th>
       <th>勤務時間</th>
     </tr>
     @foreach($rests as $rest)
       <?php
            $start_time = new DateTime($rest->attendance->start_time);
            $end_time = new DateTime($rest->attendance->end_time);
            $diff = $end_time->diff($start_time);
       ?>
     <tr>
       <td>{{ $rest->user->name }}</td>
       <td>{{ $rest->attendance->start_time }}</td>
       <td>{{ $rest->attendance->end_time }}</td>
        <?php
            $rest_start_time = new DateTime($rest->rest_start_time);
            $rest_end_time = new DateTime($rest->rest_end_time);
            $rest_diff = $rest_end_time->diff($rest_start_time);

            $work_time = new DateTime($diff->format('%H:%I:%S'));
            $rest_time = new DateTime($rest_diff->format('%H:%I:%S'));
            $diff_time = $work_time->diff($rest_time);
          ?>
        <td>
        <?php
          echo $rest_diff->format('%H:%I:%S')
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