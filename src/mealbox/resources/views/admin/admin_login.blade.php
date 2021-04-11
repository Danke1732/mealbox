@extends('layouts.admin')
@section('title', '管理者ログインフォーム')
@section('content')
<form class="form-signin" method="POST" action="{{ route('admin.login') }}">
@csrf
  <h1 class="h3 mb-3 font-weight-normal">管理者ログインフォーム</h1>
  @if ($errors->any())
    <div class="mb-3">
      <ul class="list-group list-group-flush">
        @foreach ($errors->all() as $error)
          <li class="list-group-item list-group-item-danger">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <x-alert type="danger" :session="session('danger')"/>
  
  <label for="user_id" class="sr-only">管理者ID</label>
  <input type="text" id="user_id" class="form-control mb-2" placeholder="Admin ID" name="user_id" required autofocus>
  <label for="inputPassword" class="sr-only">管理者パスワード</label>
  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
  <button class="btn btn-lg btn-primary btn-block mb-2" type="submit">ログイン</button>
  <a href="/" class="btn btn-lg btn-success btn-block">トップ画面に戻る</a>
</form>
@endsection