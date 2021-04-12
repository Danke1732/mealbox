@extends('layouts.layout')
@section('title', 'ホーム画面')
@section('content')
  <main role="main">
  <section class="jumbotron text-center mt-5">
    <div class="container">
      <h1 class="jumbotron-heading">商品メニュー一覧</h1>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row">
        @foreach ($food_list as $food)
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="{{ Storage::url($food->file_path) }}" alt="画像" width="100%" height="225" background="#55595c" color="#eceeef" class="card-img-top" style="object-fit: cover;">
            <div class="card-body">
              <p class="card-text">
                {{ $food->name }}
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-primary">詳しく見る</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="mt-3">
				{{ $food_list->links() }}
			</div>
    </div>
  </div>

</main>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">Back to top</a>
    </p>
    <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
   
  </div>
</footer>
@endsection
