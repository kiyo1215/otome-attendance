<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Atte</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv=" X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <header>
        <h1>Atte</h1>
    </header>

    <main>
        <h2>ログイン</h2>
        <div class="login-form">
            <form method="POST" action="/login">
                @csrf
                <div>
                    <input type="text" name="number" placeholder="キャストID">
                </div>
                @if ($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif

                <div>
                    <input type="password" name="password" placeholder="パスワード">
                </div>
                @if ($errors->has('password'))
                    <div class="text-danger">{{ $errors->first('password') }}</div>
                @endif

                <button type="submit">ログイン</button>
            </form>
        </div>
    </main>

    <footer>
        <p>Atte,inc.</p>
    </footer>
</body>

</html>
