@extends('layouts.admin')
@section('title', '管理者注文一覧')
@section('content')
<div class="container" style="min-width: 900px;">
  <div class="row">
    <div class="col-md-12">
    <div class="card">
		  <h3 class="card-header">注文情報一覧</h3>
		  <div class="card-body p-2 pt-3">
        <table class="table table-striped table-bordered border">
            <tr>
              <th>注文番号</th>
              <th>注文者</th>
              <th>商品</th>
              <th>注文時刻</th>
              <th>数量 (個)</th>
              <th>金額 (円)</th>
              <th>配達先</th>
              <th></th>
            </tr>
            @foreach($order_list as $order)
            <tr>
              <td>{{ $order->id }}</td>
              <td><a href="{{ route('admin.user_detail', $order->user_id) }}">{{ $order->user->last_name }} {{ $order->user->first_name }}</a></td>
              <td><a href="{{ route('food.detail', $order->food_id) }}">{{ $order->food->name }}</a></td>
              <td>{{ $order->created_at }}</td>
              <td>{{ $order->number }}</td>
              <td>{{ $order->total_price }}</td>
              <td>{{ $order->place->address }}</td>
              <td>
                <form action="{{ route('admin.order_delete', $order->id) }}" method="POST" onSubmit="return checkDelete()">
                  @csrf
                  <button class="btn btn-danger" type="submit" onclick=>削除</button>
                </form>
              </td>
            </tr>
            @endforeach
            <tr>
              <td>合計</td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{ $order_num }}</td>
              <td>{{ $order_total_price }}</td>
              <td></td>
              <td></td>
            </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="mt-3 mx-auto">
    {{ $order_list->links() }}
  </div>
		
</div>
<script>
  function checkDelete() {
    if (confirm('削除してよろしいですか？')) {
      return true;
    } else {
      return false;
    }
  }
</script>
@endsection