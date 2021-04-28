<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => 1,
            'total_price' => $this->faker->numberBetween($min = 0, $max = 1500),
            'user_id' => User::factory(),
            'food_id' => Food::factory(),
        ];
    }
}
