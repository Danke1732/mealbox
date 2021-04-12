<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FoodCreateRequest;
use App\Models\Food;

class FoodController extends Controller
{
	/**
	 * 商品を新しく掲載するためのフォームを表示
	 * @return View
	 */
	public function showUploadForm()
	{
		return view ('admin.upload_form');
	}

	/**
	 * 商品のアップロード処理
	 * @param App\Http\Requests\FoodCreateFormRequest $request
	 */
	public function upload(FoodCreateRequest $request)
	{
		$food_image = $request->file('image');
		if ($food_image) {
			// 送られてきた画像を保存する
			$path = $food_image->store('uploads', "public");
			// 画像の保存後DBに記録する
			if ($path) {
				Food::create([
					'name' => $request->input('name'),
					'price' => $request->input('price'),
					'description' => $request->input('description'),
					'file_name' => $food_image->getClientOriginalName(),
					'file_path' => $path,
				]);
			}
		}

		return redirect()->route('home');
	}

	/**
	 * 商品一覧画面の表示
	 */
	public function foodList()
	{
		$food_list = Food::orderBy("id", "desc")->paginate(8);
		return view('home', ["food_list" => $food_list]);
	}
}
