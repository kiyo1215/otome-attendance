<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>Otome Attendance Manegement</title>
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/paginate.css')}}">
  <link rel="stylesheet" href="{{asset('css/home.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv=" X-UA-Compatible" content="ie=edge">
</head>

<body>
  <header>
    <h1>Otome Attendance Management</h1>
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
    　<ul>
      <li><a href="{{ route('show_atte') }}" class="nav">勤務時間編集</a></li>
      <li><a href="{{ route('show_rest') }}" class="nav">休憩時間編集</a></li>
      <li><a href="{{ route('show_reward') }}" class="nav">勤務時間集計</a></li>
      <li><a href="{{ route('graduation') }}" class="nav">キャスト編集</a></li>
    </ul>
  </main>
</body>

</html>