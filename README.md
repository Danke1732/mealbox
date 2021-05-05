# MealBox

## アプリケーションの概要

Mealboxでは、登録しているユーザーは商品(弁当)を選択し、注文することができます。

## App URL

[https://mealbox-app.herokuapp.com/](https://mealbox-app.herokuapp.com/ "MealBox")

[![ホーム画面](https://i.gyazo.com/f8c29426e2a8b64081786128479ec517.jpg)](https://gyazo.com/f8c29426e2a8b64081786128479ec517 "アプリホーム画面")

## 制作背景
前職での経験が元になっており、お弁当の注文を電話で行っていたため、同一の苗字の方との注文違いが発生しておりました。注文者の間違いなくなることを思って、このアプリケーションを作成したいと思いました。

## ターゲット層
会社で勤務している方、大規模な団体、組織をターゲットとしてアプリケーションを作成します。

## テスト用アカウント(一般ユーザー)
personal ID : test1 

password : test1

## テスト用アカウント(管理者ユーザー)
admin ID : laravel 

password : laravel

## 利用方法
- ### 登録ユーザー
    
    商品(弁当)を選択し、注文することで商品管理部門へデータを送信することができます。

- ### 商品管理部門

    - 登録ユーザーの注文内容(商品名,個数,配達先)を確認することができます。

      [![注文管理一覧](https://i.gyazo.com/dc9d2a178daabd13d13b28f6ea51545b.jpg)](注文管理一覧)

    - 登録ユーザーの一覧を確認をすることができる。

      [![ユーザー管理一覧](https://i.gyazo.com/bcf368094d00a5f474b6d2d3be86be95.jpg)](ユーザー管理一覧)

    - 注文された内容を削除することができる。

      [![注文削除機能](https://i.gyazo.com/afd30f69347fc4bef8dd539878034a83.gif)](https://gyazo.com/afd30f69347fc4bef8dd539878034a83)

## 目指した課題解決
- 商品管理部門が商品(弁当)の注文確認ミスがなくなるようにする。
- 注文状況の確認を行えるようにする。
- ユーザー管理機能を実装する。

## 洗い出した要件
- ### (商品管理部門) 注文者一覧表示機能
  
  注文者一覧表示機能を実装し、商品名、配達先の確認、注文の削除をできるようにする。

- ### (登録ユーザー) 商品注文機能

  商品(弁当)の注文を行うことができるようにする。選択時には、商品、個数、配達先を入力し、内容を商品管理部門へ送信できるようにする。

# データベース設計

## users テーブル

| Column                | Type    | Options                   |
| --------------------- | ------- | ------------------------- |
| personal_id           | string  | null: false, unique: true |
| password              | string  | null: false               |
| first_name            | string  | null: false               |
| last_name             | string  | null: false               |

### Association

- hasMany :orders

## foods テーブル

| Column             | Type        | Options                        |
| ------------------ | ----------- | ------------------------------ |
| name               | string      | null: false, max:100           |
| description        | text        | null: false                    |
| price              | integer     | null: false, unsigned          |
| file_name          | string      | null: false                    |
| file_path          | string      | null: false                    |

### Association

- hasMany :orders

## orders テーブル

| Column         | Type                   | Options                        |
| -------------- | ---------------------- | ------------------------------ |
| user           | bigInteger(references) | foreign_key: true, unsigned    |
| food           | bigInteger(references) | foreign_key: true, unsigned    |
| number         | integer                | null: false, unsigned          |
| total_price    | integer                | null: false, unsigned          |

### Association

- belongsTo :user
- belongsTo :food
- hasOne :place

## places テーブル

| Column         | Type           | Options                        |
| -------------- | -------------  | ------------------------------ |
| address        | string         | null: false                    |
| order          | references     | null: false, foreign_key: true |

### Association

## 動作環境
- PHP 8.0.3
- Laravel 8.35.1
- docker 20.10.5
- docker-compose 1.28.5
- nginx 1.18.0
- mysql Ver 14.14