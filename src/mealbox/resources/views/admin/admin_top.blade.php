@extends('layouts.admin')
@section('title', '管理者トップページ')
@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">管理側トップページ</div>
		<div class="card-body d-flex">
			<div class="mr-2">
				<a href="{{ route('admin.user_list') }}" class="btn btn-primary">ユーザー一覧</a>
			</div>

			<form method="post" action="{{ route('admin.logout') }}">
				@csrf
				<input type="submit" class="btn btn-danger" value="ログアウト" />
			</form>
		</div>
	</div>
</div>
@endsection