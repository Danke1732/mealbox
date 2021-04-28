<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品編集フォーム</title>
  <!-- Scripts -->
  <script src="{{ secure_asset('/js/app.js') }}" defer></script>
  <!-- Styles -->
  @if (app('env') == 'heroku')
    <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('/css/form-validation.css') }}" rel="stylesheet">
  @else
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/form-validation.css') }}" rel="stylesheet">
  @endif
</head>
<body style="background-image: url('{{ asset('edit-form-image.jpg') }}'); background-size: cover; background-color:rgba(255, 255, 255, 0.3); background-blend-mode:lighten; border-radius: 0;">
  @include('shared/header')
  <div class="container" style="margin-top: 110px;">
  <div class="py-3 text-center">
    <h2>商品編集フォーム</h2>
    <p class="lead">下記の入力欄に必要な商品情報の変更内容を入力してください。</p>
  </div>

  <div class="row bg-white rounded p-3 mb-5">
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
      <form method="POST" action="{{ route('food.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $food->id }}">
        <div class="row">
          <div class="col-md-6 mb-3 form-group">
            <label for="foodName">商品名</label>
            <input type="string" name="name" class="form-control" id="foodName" value="{{ $food->name }}" placeholder="特からあげ弁当" required autofocus>
          </div>

          <div class="col-md-6 mb-3 form-group">
            <label for="price">価格</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ $food->price }}" min="0" placeholder="540" required>
          </div>
        </div>

        <div class="mb-3 form-group">
          <label for="description">商品の説明</label>
          <textarea name="description" class="form-control" id="description" placeholder="商品の説明" required>{{ $food->description }}</textarea>
        </div>

        <div class="mt-3 mb-4 form-group">
          <label for="image">商品画像の設定</label>
          <input type="file" name="image" class="d-sm-block" id="image" accept="image/png, image/jpeg">
        </div>

        <button class="btn btn-lg btn-primary btn-block shadow-sm mx-auto col-sm-6" type="submit">更新する</button>
      </form>
    </div>
  </div>
</body>
</html>