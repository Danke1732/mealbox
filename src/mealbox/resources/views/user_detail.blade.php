@extends('layouts.admin')
@section('title', 'ログインユーザー詳細')
@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">
      ユーザー詳細情報
		</div>

		<div class="card-body">
			<ul class="list-group mb-2">
				<li class="list-group-item">ユーザーID : {{ $user->personal_id }}</li>
				<li class="list-group-item">苗字 : {{ $user->last_name }}</li>
				<li class="list-group-item">名前 : {{ $user->first_name }}</li>
			</ul>
      <a class="btn btn-secondary shadow-sm" href="{{ route('home') }}">戻る</a>
		</div>
	</div>
</div>
@endsection