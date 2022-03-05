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
    @foreach ($errors->all() as $error)
    <li class="error">{{$error}}</li>
    @endforeach
    @if(session('create'))
    <div class="session">
      {{session('create')}}
    </div>
    @endif
    <div class="register">
      <form method="POST" action="{{ route('create') }}">
        @csrf
        <div>
          <input type="name" name="name" placeholder="名前" value="{{ old('name') }}">
        </div>
        <div>
          <select name="belong">
            <option value="">所属</option>
            <option value="乙女ハウス">乙女ハウス</option>
            <option value="あんじゅえーる">あんじゅえーる</option>
            <option value="ふぁみーゆ">ふぁみーゆ</option>
          </select>
        </div>
        <div>
          <input type="text" name="number" placeholder="キャストID(4桁の数字)">
        </div>
        <div>
          <input type="password" name="password" placeholder="パスワード(4桁の数字)">
        </div>
        <button type="submit">キャスト登録</button>
      </form>
    </div>
    @if(session('delete'))
    <div class="session">
      {{session('delete')}}
    </div>
    @endif
    <div class="guraduation">
      @foreach($users as $user)
      <form method="post" action="{{ route('delete') }}" style="display: flex;">
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">
        <p style="font-size: 20px;">{{$user->number}} {{ $user->name }}</p>
        <button type="submit" style="height: 30px; margin: 0 30px 0 20px;">卒業</button>
      </form>
      @endforeach
    </div>
  </main>
</body>

</html>