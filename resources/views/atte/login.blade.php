<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Site</title>
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv=" X-UA-Compatible" content="ie=edge">
</head>
<body>
  <header>
    <h1>Atte</h1>
  </header>
  <main>
    <h2>ログイン</h2>
    <div class="login-form">
      <form method="POST" action="{{ route('login') }}">
      @csrf
      @if ($errors->has('email'))
        <div class="text-danger">
          {{ $errors->first('email') }}
        </div>
      @endif
        <p><input type="email" name="email" placeholder="メールアドレス"></p>
        @if ($errors->has('password'))
        <div class="text-danger">
          {{ $errors->first('password') }}
        </div>
      @endif
        <p><input type="password" name="password" placeholder="パスワード"></p>
        <button type="submit">ログイン</button>
      </form>
      <p>アカウントをお持ちでない方はこちら</p>
      <a href="{{ route('register') }}">会員登録</a>
    </div>
  </main>
  <footer>
    <p>Atte,inc.</p>
  </footer>
</body>

</html>