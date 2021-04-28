<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseMigrations;
use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\Place;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 一般ユーザー各ページ(ログイン未)への遷移テスト
     * @return void
     */
    public function testPage()
    {
        // ログイン用ユーザーを作成
        $user = User::factory()->create();
        // 商品作成
        $food = Food::factory()->create();

        // --- 以下ログイン未の遷移テスト ---

        // ログイン画面への遷移テスト(ログイン未)
        $response = $this->get('/');
        $response->assertStatus(200);

        // 新規登録画面への遷移テスト(ログイン未)
        $response = $this->get('/signup');
        $response->assertStatus(200);

        // 管理者ログイン画面への遷移テスト(ログイン未)
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        
        // "商品一覧"への遷移テスト(ログイン未)
        $response = $this->get('/home');
        $response->assertStatus(302);

        // "商品詳細"への遷移テスト(ログイン未)
        $response = $this->get('/food/{{ $food->id }}');
        $response->assertStatus(302)->assertRedirect('/');

        // "ログインユーザー詳細"への遷移テスト(ログイン未)
        $response = $this->get('/user/{{ $user->id }}');
        $response->assertStatus(302)->assertRedirect('/');

        // --- 以下ログイン済の遷移テスト ---

        // ログイン画面の遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(302);

        // 新規登録画面への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get('/signup');
        $response->assertStatus(302);

        // "商品一覧"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        // "商品詳細"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get('/food/5');
        $response->assertStatus(200);

        // "ログインユーザー詳細"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get('/user/3');
        $response->assertStatus(200);

        // --- 管理者ページへ遷移できないテスト

        // "管理者ページ(商品登録フォーム)"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get(route('food.form'));
        $response->assertStatus(302);

        // "管理者ページ(商品編集フォーム)"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get('/admin/food_edit/1');
        $response->assertStatus(302);

        // "管理者ページ(注文管理一覧)"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get(route('admin.order_list'));
        $response->assertStatus(302);

        // "管理者ページ(管理者側トップ画面)"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get(route('admin.top'));
        $response->assertStatus(302);

        // "管理者ページ(ユーザー一覧)"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get(route('admin.user_list'));
        $response->assertStatus(302);

        // "管理者ページ(ユーザー詳細)"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get('/admin/user_detail/1');
        $response->assertStatus(302);

        // "管理者ページ(商品管理一覧)"への遷移テスト(ログイン済)
        $response = $this->actingAs($user)->get(route('admin.food_list'));
        $response->assertStatus(302);

        // "ページのないアドレス"への遷移テスト
        $response = $this->get('no_route');
        $response->assertStatus(404);
    }

    /**
     * ログイン処理テスト
     * @return void
     */
    public function testLogin()
    {
        // ログイン用ユーザーを作成
        User::create([
            'personal_id' => 'test',
            'password' => bcrypt('testPass'),
            'first_name' => 'test',
            'last_name' => 'taro',
        ]);

        // 作成したユーザーでログイン
        $response = $this->post(route('login'), [
            'personal_id' => 'test',
            'password' => 'testPass',
        ]);
        $response->assertStatus(302)->assertRedirect(route('home'));
    }

    /**
     * ログアウト処理テスト
     * @return void
     */
    public function testLogout()
    {
        // ログイン用ユーザーを作成
        $user = User::factory()->create();

        // ログアウト処理テスト
        $response = $this->actingAs($user)->post(route('logout'));
        $response->assertStatus(302)->assertRedirect('/');
    }

    /**
     * 登録したユーザー情報がDBに登録されているか確認テスト
     * @return void
     */
    public function testDB()
    {
        // 特定のユーザー情報を登録
        User::factory()->create([
            'personal_id' => 'test',
            'password' => 'testPass',
            'first_name' => 'taro',
            'last_name' => 'test',
        ]);
        // 複数のユーザーを登録
        User::factory()->count(5)->create();
        // 特定ユーザーがDBに存在するか確認
        $this->assertDatabaseHas('users', [
            'personal_id' => 'test',
            'password' => 'testPass',
            'first_name' => 'taro',
            'last_name' => 'test',
        ]);
    }
}
