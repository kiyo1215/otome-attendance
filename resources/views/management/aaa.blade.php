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
  @foreach($users as $user)
  <form method="post" action="{{route('bbb')}}">
  @csrf
    <input type="hidden" name="id" value="{{$user->id}}">
    <input type="text" name="name" value="{{$user->name}}">
    <button type="submit">変更</button>
  </form>
  @endforeach
  </main>
</body>

</html>