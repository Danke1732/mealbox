<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\Place;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 管理者ユーザーページ遷移テスト
     * @return void
     */
    public function testPage()
    {
        // ユーザーを作成
        $user = User::factory()->create();

        // 商品を作成
        $food = Food::factory()->create();

        // --- 管理者ユーザーページ遷移ログイン未テスト ---

        // 管理者ログイン画面への遷移テスト(ログイン未)
        $response = $this->get(route('admin.showLogin'));
        $response->assertStatus(200);

        // 商品登録フォーム画面への遷移テスト(ログイン未)
        $response = $this->get(route('food.form'));
        $response->assertStatus(302);

        // 商品編集フォーム画面への遷移テスト(ログイン未)
        $response = $this->get('/admin/food_edit/1');
        $response->assertStatus(302);

        // 商品管理一覧画面への遷移テスト(ログイン未)
        $response = $this->get(route('admin.food_list'));
        $response->assertStatus(302);

        // 注文管理一覧画面への遷移テスト(ログイン未)
        $response = $this->get(route('admin.order_list'));
        $response->assertStatus(302);

        // 管理者ホーム画面への遷移テスト(ログイン未)
        $response = $this->get(route('admin.top'));
        $response->assertStatus(302);

        // ユーザー一覧画面への遷移テスト(ログイン未)
        $response = $this->get(route('admin.user_list'));
        $response->assertStatus(302);

        // ユーザー詳細画面への遷移テスト(ログイン未)
        $response = $this->get('/admin/user_detail/{{ $user->id }}');
        $response->assertStatus(302);
 

        // --- 管理者ユーザーページ遷移ログイン済みテスト ---

        // 管理者ログインフォーム画面への遷移テスト(ログイン済み)
        $response = $this->withSession(['admin_auth' => true])->get(route('admin.showLogin'));
        $response->assertStatus(302)->assertRedirect(route('admin.top'));

        // 商品登録フォーム画面への遷移テスト(ログイン済み)
        $response = $this->withSession(['admin_auth' => true])->get(route('food.form'));
        $response->assertStatus(200);

        // 商品編集フォーム画面への遷移テスト(ログイン済み)
        $response = $this->withSession(['admin_auth' => true])->get('/admin/food_edit/1');
        $response->assertStatus(200);

        // 商品管理一覧画面への遷移テスト(ログイン済み)
        $response = $this->withSession(['admin_auth' => true])->get(route('admin.food_list'));
        $response->assertStatus(200);

        // 注文管理一覧画面への遷移テスト(ログイン済み)
        $response = $this->withSession(['admin_auth' => true])->get(route('admin.order_list'));
        $response->assertStatus(200);

        // 管理者ホーム画面への遷移テスト(ログイン済み)
        $response = $this->withSession(['admin_auth' => true])->get(route('admin.top'));
        $response->assertStatus(200);

        // ユーザー一覧画面への遷移テスト(ログイン済み)
        $response = $this->withSession(['admin_auth' => true])->get(route('admin.user_list'));
        $response->assertStatus(200);

        // ユーザー詳細画面への遷移テスト(ログイン済み)
        $response = $this->withSession(['admin_auth' => true])->get('/admin/user_detail/1');
        $response->assertStatus(200);
    }

    /**
     * 管理者ログインテスト
     * @return void
     */
    public function testAdminLogin()
    {
        // 管理者ユーザーでログイン
        $response = $this->withSession(['admin_auth' => false])->post(route('admin.login'), [
            'user_id' => config('admin.admin_id'),
            'password' => config('admin.admin_pass'),
        ]);
        $response->assertStatus(302)->assertRedirect(route('admin.top'));
    }

    /**
     * 管理者ログアウトテスト
     * @return void
     */
    public function testAdminLogout()
    {
        // 管理者ユーザーでログアウト
        $response = $this->withSession(['admin_auth' => true])->post(route('admin.logout'));
        $response->assertStatus(302)->assertRedirect(route('admin.showLogin'));
    }

    /**
     * 商品の削除テスト
     * @return void
     */
    public function testFoodDelete()
    {
        // 商品の作成
        $food = Food::factory()->create();
        
        $response = $this->withSession(['admin_auth' => true])->post('/admin/food_delete/2');
        $response->assertStatus(302)->assertRedirect(route('admin.food_list'));
    }

    /**
     * 注文の削除テスト
     * @return void
     */
    public function testOrderDelete()
    {
        // 商品の作成
        $food = Food::factory()->create();
        // 注文の作成
        $order = Order::factory()->has(Place::factory())->has(User::factory())->create();
        
        $response = $this->withSession(['admin_auth' => true])->post('/admin/order_delete/1');
        $response->assertStatus(302)->assertRedirect(route('admin.top'));
    }
}
