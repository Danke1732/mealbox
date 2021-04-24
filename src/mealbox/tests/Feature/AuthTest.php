<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 一般ユーザーログイン画面(ログイン未)へ遷移のテスト
     * @return void
     */
    public function testShowLogin()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * 一般ユーザーログイン処理のテスト
     * @return void
     */
    public function testUserLogin()
    {
        // ユーザーの作成
        User::create([
            'personal_id' => 'test',
            'password' => 'testPass',
            'first_name' => 'test',
            'last_name' => 'taro'
        ]);
        // 作成したユーザーでログイン
        $response = $this->post('/login', [
            'personal_id' => 'test',
            'password' => 'testPass'
        ]);
        // ログインの確認
        $response->assertStatus(201);
    }
}
