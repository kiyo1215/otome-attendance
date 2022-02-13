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
    <h1>Atte</h1>
    <ul>
      <li><a href="{{ route('index') }}">ホーム</a></li>
      <li><a href="{{ route('date') }}">日付一覧</a></li>
      <li>
       <form method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
      </li>
    </ul>
  </header>
  <main>
  <div class="date-seach">
    <form action="/attendance" method="post">
      @csrf
      <input type="hidden" name="today" value={{ $date }}>
      <input type="hidden" name="date" value="back">
      <input type="submit" value="<">
    </form>
    <p>{{ $date }}</p>
    <form action="/attendance" method="post">
      @csrf
      <input type="hidden" name="today" value={{ $date }}>
      <input type="hidden" name="date" value="next">
      <input type="submit" value=">">
    </form>
  </div>
  <div class="info">
   <table class="attendance">
     <tr>
       <th>名前</th>
       <th>日付</th>
       <th>勤務開始</th>
       <th>勤務終了</th>
     </tr>
     @foreach($attendances as $attendance)
        <tr>
          <td>{{ $attendance->user->name }}</td>
          <td>{{ $attendance->date}}
          <td>{{ $attendance->start_time }}</td>
          <td>{{ $attendance->end_time }}</td>
        </tr>
    @endforeach
    </table>

    <table class="rest">
      <tr>
      <th>休憩時間</th>
      </tr>
      @foreach($all_rests as $all_rest)
      <tr>
      <td>
      <?php
          $rest_time = str_pad($all_rest->all_time, 6, 0, STR_PAD_LEFT);
          echo wordwrap($rest_time, 2, ':', true);
      ?>
      </td>
      </tr>
      @endforeach
    </table>

    <table class="work">
      <tr>
        <th>勤務時間</th>
      </tr>
      @foreach($attendances as $attendance)
      <?php
            $start_time = new DateTime($attendance->start_time);
            $end_time = new DateTime($attendance->end_time);
            $work_time = $end_time->diff($start_time);
            $rest_time2 = new DateTime($rest_time);
            

            $diff_time = new DateTime($work_time->format('%H:%i:%s'));
       ?>
    <tr>
      <td>
        <?php
         echo $diff_time->format('H:i:s')
        ?>
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