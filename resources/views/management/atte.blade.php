<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Site</title>
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/paginate.css')}}">
  <link rel="stylesheet" href="{{asset('css/change.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv=" X-UA-Compatible" content="ie=edge">
</head>

<body>
  <header>
    <h1>Otome Attendance</h1>
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
          <th></th>
        </tr>
        @foreach($attendances as $attendance)
          <form method="post" action="{{ route('changeAtte') }}">
            @csrf
            <tr>
              <td>{{ $attendance->user->name }}</td>
              <input type="hidden" name="id" value="{{ $attendance->id }}">
              <td><input type="date" name="date" value="{{ $attendance->date }}"></td>
              <td><input type="text" name="atte_start_time" value="{{ $attendance->start_time }}"></td>
              <td><input type="text" name="atte_end_time" value="{{ $attendance->end_time }}"></td>
              <td><button type="submit">編集</button></td>
            </tr>
          </form>
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