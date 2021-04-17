@extends('layouts.admin')
@section('title', '管理者トップページ')
@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">管理側トップページ</div>
		<div class="card-body d-flex">
			<div class="mr-2">
				<a href="{{ route('admin.user_list') }}" class="btn btn-primary mb-1 mb-sm-0 mr-1">ユーザー一覧</a>
				<a href="{{ route('admin.food_list') }}" class="btn btn-primary mb-1 mb-sm-0 mr-1">商品管理一覧</a>
				<a href="{{ route('admin.order_list') }}" class="btn btn-primary mb-1 mb-sm-0 mr-1">注文管理一覧</a>
				<a href="{{ route('food.form') }}" class="btn btn-primary">商品投稿</a>
			</div>

			<form method="post" action="{{ route('admin.logout') }}" class="mb-1 mb-sm-0">
				@csrf
				<input type="submit" class="btn btn-danger" value="ログアウト" />
			</form>
		</div>
	</div>
</div>
@endsection