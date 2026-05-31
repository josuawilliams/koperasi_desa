<?php

namespace Database\Seeders;

use App\Models\Carts;
use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'buyer@example.com'],
            ['name' => 'Buyer Koperasi', 'password' => bcrypt('password')]
        );

        $product = Products::where('stock', '>', 0)->orderBy('id')->first();

        if (! $product) {
            return;
        }

        $quantity = min(2, $product->stock);

        $cart = Carts::firstOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
            ['quantity' => $quantity]
        );

        if ($cart->wasRecentlyCreated) {
            $product->decrement('stock', $quantity);
        }
    }
}
