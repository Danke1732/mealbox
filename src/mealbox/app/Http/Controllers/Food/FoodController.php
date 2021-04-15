<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FoodCreateRequest;
use App\Models\Food;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FoodUpdateRequest;

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
				\DB::beginTransaction();
				try {
					Food::create([
						'name' => $request->input('name'),
						'price' => $request->input('price'),
						'description' => $request->input('description'),
						'file_name' => $food_image->getClientOriginalName(),
						'file_path' => $path,
					]);
					\DB::commit();
				} catch(\Throwable $e) {
					\DB::rollback();
					abort(500);
				}
				
			}
		}

		return redirect()->route('admin.food_list');
	}

	/**
	 * 商品一覧画面の表示
	 */
	public function foodList()
	{
		$food_list = Food::orderBy("id", "desc")->paginate(9);
		return view('home', ["food_list" => $food_list]);
	}

	/**
	 * 商品を新しく掲載するためのフォームを表示
	 * @return View
	 */
	public function foodDetail($id)
	{
		$food = Food::findOrFail($id);
		return view('food.food_detail', ["food" => $food]);
	}

	/**
	 * 商品内容の編集フォームを表示
	 * @return View
	 */
	public function foodEdit($id)
	{
		$food = Food::findOrFail($id);
		return view ('admin.edit_form', ["food" => $food]);
	}

	/**
	 * 商品の更新処理
	 * @param App\Http\Requests\FoodCreateFormRequest $request
	 */
	public function foodUpdate(FoodUpdateRequest $request)
	{
		// 送られてきたデータを取得
		$inputs = $request->all();
		// 送られてきたデータから商品を検索
		$food = Food::findOrFail($inputs['id']);
		// 送られてきたデータを元に更新処理
		\DB::beginTransaction();
		try {
			if (isset($inputs['image']) === true && $food['file_name'] !== $inputs['image']->getClientOriginalName()) {
				// 元の画像を削除
				Storage::delete('/public/uploads/' . $food['file_name']);
				// 新しい画像を保存
				$path = $inputs['image']->store('uploads', "public");
				// 画像情報の内容を更新
				$food->fill([
					'file_name' => $inputs['image']->getClientOriginalName(),
					'file_path' => $path,
				]);
			}
			// 画像以外の内容を更新
			$food->fill([
				'name' => $inputs['name'],
				'price' => $inputs['price'],
				'description' => $inputs['description'],
			]);

			$food->save();
			// 登録に成功したら実際に登録
			\DB::commit();
		} catch(\Throwable $e) {
			\DB::rollback();
			echo $e;
			abort(500);
		}
		// ホーム画面へリダイレクト
		return redirect()->route('admin.food_list');
	}
}
