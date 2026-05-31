<?php

namespace Tests\Feature;

use App\Models\Products;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WelcomeSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_filters_products_by_search_keyword(): void
    {
        $user = User::factory()->create();
        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Sembako',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->createProduct($user->id, $categoryId, 'Beras Premium');
        $this->createProduct($user->id, $categoryId, 'Minyak Goreng');

        $response = $this->get(route('welcome', ['search' => 'beras']));

        $response->assertOk();
        $response->assertSee('Beras Premium');
        $response->assertDontSee('Minyak Goreng');
    }

    private function createProduct(int $userId, int $categoryId, string $name): Products
    {
        return Products::create([
            'user_id' => $userId,
            'category_id' => $categoryId,
            'name' => $name,
            'slug' => str($name)->slug(),
            'description' => 'Deskripsi produk test',
            'price' => 10000,
            'stock' => 10,
            'image' => 'test.jpg',
            'is_visible' => true,
        ]);
    }
}
