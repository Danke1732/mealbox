@extends('layouts.admin')
@section('title', '管理者ユーザー一覧')
@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">ユーザー一覧</div>
		<div class="card-body">
			<ul class="list-group">
				@foreach ($user_list as $user)
				<li class="list-group-item">
					<a href="/admin/user_detail/{{ $user->id }}">
						{{ $user->personal_id }}
					</a>
				</li>
				@endforeach
			</ul>

			<div class="mt-3 mx-auto">
				{{ $user_list->links() }}
			</div>
		</div>
	</div>
</div>
@endsection