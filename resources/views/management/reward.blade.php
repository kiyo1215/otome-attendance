<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Site</title>
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/paginate.css')}}">
  <link rel="stylesheet" href="{{asset('css/reward.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv=" X-UA-Compatible" content="ie=edge">
</head>

<body>
  <header>
    <h1>Otome Attendance Management</h1>
    <ul>
      <li><a href="{{ route('showAtte') }}">勤務時間編集</a></li>
      <li><a href="{{ route('showRest') }}">休憩時間編集</a></li>
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
        <div class="belong">所属
          <select name="belong">
            <option value="">全て</option>
            <option value="乙女ハウス">乙女ハウス</option>
            <option value="あんじゅえーる">あんじゅえーる</option>
            <option value="ふぁみーゆ">ふぁみーゆ</option>
          </select>
          <div class="day">日付<input type="date" name="date_start">
            〜<input type="date" name="date_end"></div>
          <button type="submit">検索</button>
      </form>
    </div>
    <div class="info">
      <table class="attendance">
        <tr>
          <th class="name">名前<br>所属</th>
          <th>日付</th>
          <th>全日：<br>〜19時</th>
          <th>平日・日：<br>19〜22時</th>
          <th>平日・日：<br>22時〜</th>
          <th>金土：<br>19時〜22時</th>
          <th>金土：<br>22時〜</th>
        </tr>
        @foreach($attendances as $attendance)
        @php
        $start = new DateTime($attendance->start_time);
        $start_second = ($start->format('H') * 3600) + ($start->format('i') * 60) + $start->format('s');
        $end = new DateTime($attendance->end_time);
        $end_second = ($end->format('H') * 3600) + ($end->format('i') * 60) + $end->format('s');
        @endphp
        <tr>
          <td>{{ $attendance->user->name }}<br>{{ $attendance->user->belong }}</td>
          <td>{{ $attendance->date}}<br>({{ $attendance->week }})</td>
          <!-- 全日　〜19時 -->
          <td class="time">
            @php
            if($start_second < 68400){ $time1=68400 - $start_second; $time1_hours=floor($time1 / 3600); $time1_minutes=floor(($time1 / 60) % 60); $time1_seconds=$time1 % 60; echo (sprintf("%02d:%02d:%02d", $time1_hours, $time1_minutes, $time1_seconds)); } @endphp </td>
              <!-- 平日19〜22時 -->
          <td>
            @php
            if($attendance->week !== '金' && $attendance->week !== '土'){
            if($start_second < 68400 && ($end_second> 79200 || $end_second < 28800)){ echo (sprintf("%02d:%02d:%02d", 03, 00, 00)); } if($start_second> 68400 && $start_second <= 79200 && $end_second> 79200){
                  $time2 = 79200 - $start_second;
                  $time2_hours = floor($time2 / 3600);
                  $time2_minutes = floor(($time2 / 60) % 60);
                  $time2_seconds = $time2 % 60;
                  echo (sprintf("%02d:%02d:%02d", $time2_hours, $time2_minutes, $time2_seconds));
                  }

                  if($start_second > 68400 && $end_second <= 79200 && $end_second> 28800){
                    $time3 = $end_second - $start_second;
                    $time3_hours = floor($time3 / 3600);
                    $time3_minutes = floor(($time3 / 60) % 60);
                    $time3_seconds = $time3 % 60;
                    echo (sprintf("%02d:%02d:%02d", $time3_hours, $time3_minutes, $time3_seconds));
                    }

                    if($start_second < 68400 && $end_second <=79200 && $end_second> 68400){
                      $time4 = $end_second - 68400;
                      $time4_hours = floor($time4 / 3600);
                      $time4_minutes = floor(($time4 / 60) % 60);
                      $time4_seconds = $time4 % 60;
                      echo (sprintf("%02d:%02d:%02d", $time4_hours, $time4_minutes, $time4_seconds));
                      }
                      }
                      @endphp
          </td>
          <!-- 平日22時〜 -->
          <td>
            @php
            if($attendance->week !== '金' && $attendance->week !== '土' ){
            if($start_second <= 79200 && $end_second <=86400 && $end_second> 79200){
              $time5 = 86400 - $start_second;
              $time5_hours = floor($time5 / 3600);
              $time5_minutes = floor(($time5 / 60) % 60);
              $time5_seconds = $time5 % 60;
              echo (sprintf("%02d:%02d:%02d", $time5_hours, $time5_minutes, $time5_seconds));
              }
              if($start_second <= 79200 && $end_second < 28800){ $time6=7200 + $end_second; $time6_hours=floor($time6 / 3600); $time6_minutes=floor(($time6 / 60) % 60); $time6_seconds=$time6 % 60; echo (sprintf("%02d:%02d:%02d", $time6_hours, $time6_minutes, $time6_seconds)); } if($start_second <=79200 && $end_second>= 28800 && $end_second < 43200){ echo (sprintf("%02d:%02d:%02d", 10, 00, 00)); } if(($start_second> 79200 && $end_second <= 86400 && $end_second> 79200) || ($start_second <= 28800 && $end_second <=28800)){ $time7=$end_second - $start_second; $time7_hours=floor($time7 / 3600); $time7_minutes=floor(($time7 / 60) % 60); $time7_seconds=$time7 % 60; echo (sprintf("%02d:%02d:%02d", $time7_hours, $time7_minutes, $time7_seconds)); } if($start_second> 79200 && $end_second < 28800){ $time8=86400 + $end_second - $start_second; $time8_hours=floor($time8 / 3600); $time8_minutes=floor(($time8 / 60) % 60); $time8_seconds=$time8 % 60; echo (sprintf("%02d:%02d:%02d", $time8_hours, $time8_minutes, $time8_seconds)); } if($start_second> 79200 && $end_second > 28800 && $end_second < 43200){ $time9=108000 - $start_second; $time9_hours=floor($time9 / 3600); $time9_minutes=floor(($time9 / 60) % 60); $time9_seconds=$time9 % 60; echo (sprintf("%02d:%02d:%02d", $time9_hours, $time9_minutes, $time9_seconds)); } if($start_second <=28800 && $end_second>= 28800){
                          $time10 = 28800 - $start_second;
                          $time10_hours = floor($time10 / 3600);
                          $time10_minutes = floor(($time10 / 60) % 60);
                          $time10_seconds = $time10 % 60;
                          echo (sprintf("%02d:%02d:%02d", $time10_hours, $time10_minutes, $time10_seconds));
                          }
                          }
                          @endphp
          </td>
          <td>
            @php
            if($attendance->week === '金' || $attendance->week === '土'){
            if($start_second < 68400 && ($end_second> 79200 || $end_second < 28800)){ echo (sprintf("%02d:%02d:%02d", 03, 00, 00)); } if($start_second> 68400 && $start_second <= 79200 && $end_second> 79200){
                  $time2 = 79200 - $start_second;
                  $time2_hours = floor($time2 / 3600);
                  $time2_minutes = floor(($time2 / 60) % 60);
                  $time2_seconds = $time2 % 60;
                  echo (sprintf("%02d:%02d:%02d", $time2_hours, $time2_minutes, $time2_seconds));
                  }

                  if($start_second > 68400 && $end_second <= 79200 && $end_second> 28800){
                    $time3 = $end_second - $start_second;
                    $time3_hours = floor($time3 / 3600);
                    $time3_minutes = floor(($time3 / 60) % 60);
                    $time3_seconds = $time3 % 60;
                    echo (sprintf("%02d:%02d:%02d", $time3_hours, $time3_minutes, $time3_seconds));
                    }

                    if($start_second < 68400 && $end_second <=79200 && $end_second> 68400){
                      $time4 = $end_second - 68400;
                      $time4_hours = floor($time4 / 3600);
                      $time4_minutes = floor(($time4 / 60) % 60);
                      $time4_seconds = $time4 % 60;
                      echo (sprintf("%02d:%02d:%02d", $time4_hours, $time4_minutes, $time4_seconds));
                      }
                      }
                      @endphp
          </td>
          <td>
            @php
            if($attendance->week === '金' || $attendance->week === '土'){
            if($start_second <= 79200 && $end_second <=86400 && $end_second> 79200){
              $time5 = 86400 - $start_second;
              $time5_hours = floor($time5 / 3600);
              $time5_minutes = floor(($time5 / 60) % 60);
              $time5_seconds = $time5 % 60;
              echo (sprintf("%02d:%02d:%02d", $time5_hours, $time5_minutes, $time5_seconds));
              }
              if($start_second <= 79200 && $end_second < 28800){ $time6=7200 + $end_second; $time6_hours=floor($time6 / 3600); $time6_minutes=floor(($time6 / 60) % 60); $time6_seconds=$time6 % 60; echo (sprintf("%02d:%02d:%02d", $time6_hours, $time6_minutes, $time6_seconds)); } if($start_second <=79200 && $end_second>= 28800){
                echo (sprintf("%02d:%02d:%02d", 10, 00, 00));
                }

                if(($start_second > 79200 && $end_second <= 86400 && $end_second> 79200) || ($start_second <= 28800 && $end_second <=28800)){ $time7=$end_second - $start_second; $time7_hours=floor($time7 / 3600); $time7_minutes=floor(($time7 / 60) % 60); $time7_seconds=$time7 % 60; echo (sprintf("%02d:%02d:%02d", $time7_hours, $time7_minutes, $time7_seconds)); } if($start_second> 79200 && $end_second < 28800){ $time8=86400 + $end_second - $start_second; $time8_hours=floor($time8 / 3600); $time8_minutes=floor(($time8 / 60) % 60); $time8_seconds=$time8 % 60; echo (sprintf("%02d:%02d:%02d", $time8_hours, $time8_minutes, $time8_seconds)); } if($start_second> 79200 && $end_second > 28800){
                      $time9 = 108000 - $start_second;
                      $time9_hours = floor($time9 / 3600);
                      $time9_minutes = floor(($time9 / 60) % 60);
                      $time9_seconds = $time9 % 60;
                      echo (sprintf("%02d:%02d:%02d", $time9_hours, $time9_minutes, $time9_seconds));
                      }
                      if($start_second <= 28800 && $end_second>= 28800){
                        $time10 = 28800 - $start_second;
                        $time10_hours = floor($time10 / 3600);
                        $time10_minutes = floor(($time10 / 60) % 60);
                        $time10_seconds = $time10 % 60;
                        echo (sprintf("%02d:%02d:%02d", $time10_hours, $time10_minutes, $time10_seconds));
                        }
                        }
                        @endphp
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    <a href="{{ route('showCsv')}}" class="csv">CSVダウンロード</a>
    {{ $attendances->links() }}
  </main>
  <footer>
    <p>Atte,inc.</p>
  </footer>
</body>

</html>