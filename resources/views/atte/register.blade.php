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
        <h2>会員登録</h2>
        <div class="login-form">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    <input type="name" name="name" placeholder="名前" value="{{ old('name') }}">
                </div>
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif

                <div>
                    <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
                </div>
                @if ($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif

                <div>
                    <input type="password" name="password" placeholder="パスワード(8文字以上)">
                </div>
                @if ($errors->has('password'))
                    <div class="text-danger">{{ $errors->first('password') }}</div>
                @endif

                <div>
                    <input type="password" name="password_confirmation" placeholder="確認用パスワード">
                </div>

                <button type="submit">会員登録</button>
            </form>

            <p>アカウントをお持ちの方はこちらから</p>
            <a href="login">ログイン</a>
        </div>
    </main>

    <footer>
        <p>Atte,inc.</p>
    </footer>
</body>

</html>
