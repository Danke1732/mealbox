<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログインフォーム</title>
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" >
  <link href="{{ asset('css/signin.css') }}" rel="stylesheet" >
</head>
<body>
  <form class="form-signin" method="POST" action="{{ route('login') }}">
  @csrf
    <h1 class="h3 mb-3 font-weight-normal">ログインフォーム</h1>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <label for="inputPersonID" class="sr-only">ユーザーID</label>
    <input type="text" id="inputPersonID" class="form-control mb-2" placeholder="Personal ID" name="personal_id" required autofocus>
    <label for="inputPassword" class="sr-only">パスワード</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
  </form>
</body>
</html>

