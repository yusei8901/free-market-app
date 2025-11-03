<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment_method' => 'card',
            'postal_code' => '111-1111',
            'address' => $this->faker->city(),
        ];
    }
}
