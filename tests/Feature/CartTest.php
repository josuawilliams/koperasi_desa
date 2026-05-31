<?php

namespace Tests\Feature;

use App\Models\Products;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_without_role_can_add_product_to_cart_and_reduce_stock(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(stock: 5);

        $response = $this->actingAs($user)->post("/cart/{$product->id}", [
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $this->assertSame(3, $product->fresh()->stock);
    }

    public function test_authenticated_user_can_delete_their_cart_item_and_restore_product_stock(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(stock: 3);

        DB::table('carts')->insert([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->delete('/cart/1');

        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $this->assertSame(5, $product->fresh()->stock);
    }

    private function createProduct(int $stock): Products
    {
        $owner = User::factory()->create();
        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Sembako',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Products::create([
            'user_id' => $owner->id,
            'category_id' => $categoryId,
            'name' => 'Beras Premium',
            'slug' => 'beras-premium',
            'description' => 'Beras kualitas koperasi.',
            'price' => 75000,
            'stock' => $stock,
            'image' => null,
            'is_visible' => true,
        ]);
    }
}
