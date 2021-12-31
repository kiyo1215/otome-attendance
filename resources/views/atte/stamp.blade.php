<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Site</title>
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/stamp.css')}}">
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
   <h2>{{ Auth::user()->name }}さんお疲れ様です！</h2>
   <div class="date-box">
     <div class="box">勤務開始</div>
     <div class="box">勤務終了</div>
   </div>
   <div class="date-box">
     <div class="box">休憩開始</div>
     <div class="box">休憩終了</div>
   </div>
  </main>
  <footer>
    <p>Atte,inc.</p>
  </footer>
</body>

</html>