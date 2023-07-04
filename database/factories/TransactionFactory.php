<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seller = Seller::has('products')->with('products')->get()->random();
        $buyer = User::all()->except($seller->id)->random();
        $product = $seller->products->random();
        return [
            'buyer_id' => $buyer->id,
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, $product->quantity)
        ];
    }
}
