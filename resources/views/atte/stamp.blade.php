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
      <li><a href="{{ route('index') }}">ホーム</a></li>
      <li><a href="{{ route('date') }}">日付一覧</a></li>
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
   <!-- メッセージを１個に -->
   @foreach ($errors->any() as $error)
      <li>{{$error}}</li>
    @endforeach

   <div class="date-box">
   <!-- actionを変える -->
    <form method="post" class="time-add" action="/attendance/start">
      @csrf
    <!-- controllerにstart_timeとdateをうつす -->
    <input type="date" name="date" value="\Carbon\Carbon::today()->format("Y/m/d")">
    <input type="time" name="start_time" value="\Carbon\Carbon::now()->format("H:i:s")">
      <button type="submit" class="start_time" id="start_time">勤務開始</button>
    </form>
    
    <!-- actionを変える -->
    <form method="post" class="time-add" action="/attendance/end">
      @csrf
    <!-- controllerにend_timeをうつす -->
    <input type="time" name="end_time" value="\Carbon\Carbon::now()->format("H:i:s")">
      <button type="submit" class="end_time" id="end_time">勤務終了</button>
    </form>
   </div>
   @if (session('rest_start'))
    <div class="session">
        {{ session('rest_start') }}
    </div>
    @endif
   @if (session('rest_end'))
    <div class="session">
        {{ session('rest_end') }}
    </div>
    @endif
    
    @foreach ($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach

   <div class="date-box">
    <form method="post" class="time-add" action="/rest/start">
    @csrf
      <button type="submit" class="rest_start_time">休憩開始</button>
    </form>
    
    <form method="post" class="time-add" action="/rest/end">
    @csrf
      <button type="submit" class="rest_end_time">休憩終了</button>
    </form>
   </div>
  </main>
  <footer>
    <p>Atte,inc.</p>
  </footer>
</body>

</html>