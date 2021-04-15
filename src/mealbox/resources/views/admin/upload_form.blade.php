<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品登録フォーム</title>
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/form-validation.css') }}" rel="stylesheet">
</head>
<body>
  @include('shared/header')
  <div class="container" style="margin-top: 110px;">
  <div class="py-5 text-center">
    <h2>商品登録フォーム</h2>
    <p class="lead">下記の入力欄に必要な商品情報を全て入力してください。</p>
  </div>

  <div class="row">
    <div class="col-md-12 order-md-1">
      <h4 class="mb-3">商品の設定</h4>
      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <x-alert type="danger" :session="session('danger')"/>
      <form method="POST" action="{{ route('food.upload') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3 form-group">
            <label for="foodName">商品名</label>
            <input type="string" name="name" class="form-control" id="foodName" placeholder="(例) 特からあげ弁当" required autofocus>
          </div>

          <div class="col-md-6 mb-3 form-group">
            <label for="price">価格</label>
            <input type="number" name="price" class="form-control" id="price" min="0" placeholder="(例) 540" required>
          </div>
        </div>

        <div class="mb-3 form-group">
          <label for="description">商品の説明</label>
          <textarea name="description" class="form-control" id="description" placeholder="(例) 商品の説明です。" required></textarea>
        </div>

        <div class="mt-3 mb-4 form-group">
          <label for="image">商品画像の設定</label>
          <input type="file" name="image" class="d-sm-block" id="image" accept="image/png, image/jpeg" required>
        </div>

        <button class="btn btn-lg btn-primary btn-block mx-auto col-sm-6 mb-5" type="submit">登録する</button>
      </form>
    </div>
  </div>
</body>
</html>