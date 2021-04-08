<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ホーム画面</title>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="mt-5">
      <x-alert type="success" :session="session('success')"/>
      <h3>プロフィール</h3>
    </div>
    <ul>
      <li>ID : {{ Auth::user()->personal_id }}</li>
      <li>苗字 : {{ Auth::user()->last_name }}</li>
      <li>名前 : {{ Auth::user()->first_name }}</li>
    </ul>
    <form action="{{ route('logout') }}" method="POST" class="mt-3">
      @csrf
      <button class="btn btn-danger">ログアウト</button>
    </form>
  </div>
</body>
</html>