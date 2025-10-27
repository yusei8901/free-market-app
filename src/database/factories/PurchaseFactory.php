<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment' => 'コンビニ払い',
            'postal_code' => '111-1111',
            'address' => $this->faker->city(),
        ];
    }
}
