<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Models\Place;
use App\Http\Requests\OrderFormRequest;

class OrderController extends Controller
{
    public function purchase(OrderFormRequest $request)
    {
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            // 注文オブジェクト作成
            $order = new Order();
            // 注文された商品のidを取得
            $food = Food::find($inputs['foodId']);
            // 注文情報を入力
            $order->fill([
                'user_id' => $request['userId'],
                'food_id' => $request['foodId'],
                'number' => 1,
                'total_price' => $food['price'],
            ]);
            // 注文内容を保存
            $order->save();

            // 作成した注文のidを取得
            $orderId = $order->id;
            // 作成した注文の送り先データを取得
            $orderPlace = $inputs['address'];
            // Placeオブジェクト作成
            $place = new Place();
            $place->fill([
                'address' => $orderPlace,
                'order_id' => $orderId,
            ]);
            // 注文に結びつく送り先の保存
            $place->save();

            \DB::commit();
            return redirect()->route('home')->with('success', '商品の購入が完了しました！');

        } catch(\Throwable $e) {
            \DB::rollback();
            return redirect()->route('home')->with('danger', '商品の購入に失敗しました。');
        }
    }
}
