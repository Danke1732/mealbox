@extends('layouts.layout')
@section('title',"-- " . $food->name . "の情報詳細 --")
@section('content')
  <main role="main">
  <section class="jumbotron text-center mt-5 pb-md-5 pb-2">
    <div class="container mt-5 mt-sm-0">
      <h1 class="jumbotron-heading pt-4 pt-md-0">{{ $food->name }}</h1>
    </div>
  </section>

  <div class="album py-3 py-md-5 bg-light">
    <div class="container d-md-flex justify-content-between">

      <div class="col-sm-8 mx-auto col-md-6 mb-3">
        <img src="{{ Storage::url($food->file_path) }}" alt="画像" width="100%" height="200" background="#55595c" color="#eceeef" class="img-thumbnail img-fluid">
      </div>

      <div class="col-sm-8 mx-auto col-md-6">
        <div class="card">
          <div class="card-header card-title font-weight-bold h5">
            商品情報
          </div>
          <div class="card-body">
            <h6 class="card-title border-bottom pb-2">商品名 : <span class="font-weight-bold">{{ $food->name }}</span></h6>
            <p class="card-text border-bottom pb-2">商品価格 : <span class="font-weight-bold">{{ $food->price }} 円</span></p>
            <p>
              商品の説明
            </p>
            <p class="card-text font-weight-bold">
              {{ $food->description }}
            </p>
          </div>
        </div>
        <div class="mt-3">
          <a class="btn btn-primary mr-2" href="#">購入する</a>
          <a class="btn btn-secondary" href="{{ route('home') }}">商品一覧に戻る</a>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
