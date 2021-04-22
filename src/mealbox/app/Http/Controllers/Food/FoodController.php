<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FoodCreateRequest;
use App\Models\Food;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FoodUpdateRequest;
use JD\Cloudder\Facades\Cloudder;

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
	 * @param App\Http\Requests\FoodCreateRequest $request
	 */
	public function upload(FoodCreateRequest $request)
	{
		// 送られてきた画像データを取得
		$food_image = $request->file('image');
		if ($food_image) {
			// アップロードされたファイルの絶対パスを取得
			$img = $food_image->getRealPath();
			// Cloudinaryへアップロード
			Cloudder::upload($img, null);
			// 直前にcloudinaryにアップロードされた画像の名前を取得
			$publicId = Cloudder::getPublicId();
			// 上で取得した名前を取得した画像のurlを生成する
			$logoUrl = Cloudder::secureShow($publicId, [
				// 保存される際の画像の幅、高さ指定
				'width' => 500,
				'height' => 400,
			]);

			// 画像の保存後DBに記録する
			\DB::beginTransaction();
			try {
				Food::create([
					'name' => $request->input('name'),
					'price' => $request->input('price'),
					'description' => $request->input('description'),
					'file_name' => $publicId,
					'file_path' => $logoUrl,
				]);
				\DB::commit();
			} catch(\Throwable $e) {
				\DB::rollback();
				abort(500);
			}
		}

		return redirect()->route('admin.food_list')->with('success', '商品の投稿が完了しました。');
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
	 * 商品詳細を表示
	 * @return View
	 */
	public function foodDetail($id)
	{
		$food = Food::findOrFail($id);
		$addresses = config('place.addresses');
		return view('food.food_detail', ["food" => $food, "addresses" => $addresses]);
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
			// 画像についての更新を行うかチェック
			if (isset($inputs['image']) === true) {
				// 元の画像を削除
				if (isset($food->file_name)) {
					Cloudder::destroyImage($food->file_name);
				}
				// 新しい画像を保存
				$img = $inputs['image']->getRealPath();
				// Cloudinaryへアップロード
				Cloudder::upload($img, null);
				// 直前にcloudinaryにアップロードされた画像の名前を取得
				$publicId = Cloudder::getPublicId();
				// 上で取得した名前を取得した画像のurlを生成する
				$logoUrl = Cloudder::secureShow($publicId, [
					'width' => 500,
				'height' => 400,
				]);
				// 画像情報の内容を更新
				$food->fill([
					'file_name' => $publicId,
					'file_path' => $logoUrl,
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
		// 商品管理一覧へリダイレクト
		return redirect()->route('admin.food_list')->with('success', '商品の更新が完了しました。');
	}
}
