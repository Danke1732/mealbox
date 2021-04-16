<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * 商品情報を所有しているユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 商品情報を所有している商品を取得
     */
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    protected $table = "orders";
    protected $fillable = [
        'user_id',
        'food_id',
        'number',
        'total_price',
    ];
}
