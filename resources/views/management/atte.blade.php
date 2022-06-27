<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>Otome Attendance Manegement</title>
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/paginate.css')}}">
  <link rel="stylesheet" href="{{asset('css/change.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv=" X-UA-Compatible" content="ie=edge">
</head>

<body>
  <header>
    <h1>Otome Attendance Manegement</h1>
    <ul>
      <li><a href="{{ route('management') }}">トップへ</a></li>
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
      <form method="post" action="{{ route('atte_search')}}">
        @csrf
        <div>名前
          <select name="user_id">
            <option value="">全員</option>
            @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="day">日付<input type="date" name="date_start"><span>
            〜</span><input type="date" name="date_end"></div>
        <button type="submit" class="search-button">検索</button>
      </form>
    </div>
    <div class="info">
      <table class="attendance">
        <tr>
          <th class="w-20">名前</th>
          <th class="w-20">日付</th>
          <th class="w-20">勤務開始</th>
          <th class="w-20">勤務終了</th>
          <th class="w-10"></th>
          <th class="w-10"></th>
        </tr>
        @foreach($attendances as $attendance)
        <form method="post" action="{{ route('change_atte') }}">
          @csrf
          <tr>
            <td>{{ $attendance->user->name }}</td>
            <input type="hidden" name="id" value="{{ $attendance->id }}">
            <td><input type="date" name="date" value="{{ $attendance->date }}"></td>
            <td><input type="text" name="atte_start_time" value="{{ $attendance->start_time }}"></td>
            <td><input type="text" name="atte_end_time" value="{{ $attendance->end_time }}"></td>
            <td><button type="submit">編集</button></td>
            <td>
              <a href="/atte/delete/{{$attendance->id}}">削除</a>
            </td>
        </form>
        {{-- <form method="post" action="{{ route('atte_delete') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $attendance->id }}">
        <button type="submit">削除</button>
        </form> --}}
        @endforeach
      </table>
    </div>
    <div class="page">{{ $attendances->links() }}</div>
  </main>
</body>

</html>