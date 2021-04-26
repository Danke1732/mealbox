<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録フォーム</title>
  <!-- Scripts -->
  <script src="{{ secure_asset('/js/app.js') }}" defer></script>
  <!-- Styles -->
  @if (app('env') == 'heroku')
    <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('/css/signin.css') }}" rel="stylesheet">
  @else
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/signin.css') }}" rel="stylesheet">
  @endif
</head>
<body style="background: url('{{ asset('home-image.jpg') }}'); background-size: cover; background-size: cover; background-color:rgba(255,255,255,0.2); background-blend-mode:lighten;">
  @include('shared/header')
  <x-alert type="danger" :session="session('danger')"/>
  <form class="form-signin mt-5 bg-white rounded" method="POST" action="{{ route('signup') }}">
  @csrf
    <h1 class="h3 mb-3 font-weight-normal">ユーザー登録フォーム</h1>
    @if ($errors->any())
      <div class="mb-3">
        <ul class="list-group list-group-flush">
          @foreach ($errors->all() as $error)
            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    
    <label for="inputPersonID">ユーザーID</label>
    <input type="text" id="inputPersonID" class="form-control mb-2" placeholder="Personal ID" name="personal_id" required autofocus>

    <label for="inputPassword">パスワード</label>
    <input type="password" id="inputPassword" name="password" class="form-control mb-2" placeholder="Password" required>

    <label for="inputLast_name">苗字</label>
    <input type="text" id="inputLast_name" name="last_name" class="form-control mb-2" placeholder="山田" required>

    <label for="inputFirst_name">名前</label>
    <input type="text" id="inputFirst_name" name="first_name" class="form-control mb-3" placeholder="花太郎" required>

    <button class="btn btn-lg btn-primary btn-block mb-2 shadow-sm" type="submit">登録する</button>
    <a href="/" class="btn btn-lg btn-success btn-block shadow-sm">ログイン</a>
  </form>
</body>
</html>