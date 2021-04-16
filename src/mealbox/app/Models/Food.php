<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    /**
     * 商品の注文情報を取得
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected $table = "foods";
    protected $fillable = [
        'name',
        'description',
        'price',
        'file_name',
        'file_path',
    ];
}
