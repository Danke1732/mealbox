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
    @if (session('login_success'))
      <div class="alert alert-success">
        {{ session('login_success') }}
      </div>
    @endif
    <div class="mt-5">
      <h3>プロフィール</h3>
    </div>
    <ul>
      <li>ID : {{ Auth::user()->personal_id }}</li>
      <li>苗字 : {{ Auth::user()->first_name }}</li>
      <li>名前 : {{ Auth::user()->last_name }}</li>
    </ul>
  </div>
</body>
</html>