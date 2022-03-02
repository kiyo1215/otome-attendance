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
      <form method="post" action="{{ route('csv')}}">
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
        </div>
        <div class="day">日付<input type="date" name="date_start">
          〜<input type="date" name="date_end"></div>
        <button type="submit">CSVダウンロード</button>
      </form>
    </div>
  </main>
  <footer>
    <p>Atte,inc.</p>
  </footer>
</body>

</html>