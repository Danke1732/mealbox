<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Http\Requests\OrderFormRequest;

class OrderController extends Controller
{
    public function purchase(OrderFormRequest $request)
    {
        $inputs = $request->all();

        $food = Food::find($inputs['foodId']);

        \DB::beginTransaction();
        try {
            Order::create([
                'user_id' => $request['userId'],
                'food_id' => $request['foodId'],
                'number' => 1,
                'total_price' => $food['price'],
            ]);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        return redirect()->route('home')->with('success', '商品の購入が完了しました！');
    }
}
