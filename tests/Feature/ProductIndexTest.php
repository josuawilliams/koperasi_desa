<?php

namespace Tests\Feature;

use App\Models\Products;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_see_all_products(): void
    {
        $superAdmin = User::factory()->create();
        $admin = User::factory()->create();
        Role::create(['name' => 'super_admin']);
        $superAdmin->assignRole('super_admin');

        $this->createProductFor($superAdmin, 'Produk Super Admin');
        $this->createProductFor($admin, 'Produk Admin');

        $response = $this->actingAs($superAdmin)->get(route('product.index'));

        $response->assertOk();
        $response->assertViewHas('products', function ($products) {
            return $products->pluck('name')->contains('Produk Super Admin')
                && $products->pluck('name')->contains('Produk Admin');
        });
    }

    public function test_admin_can_only_see_their_own_products(): void
    {
        $admin = User::factory()->create();
        $otherAdmin = User::factory()->create();
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->createProductFor($admin, 'Produk Milik Admin');
        $this->createProductFor($otherAdmin, 'Produk Admin Lain');

        $response = $this->actingAs($admin)->get(route('product.index'));

        $response->assertOk();
        $response->assertViewHas('products', function ($products) {
            return $products->pluck('name')->contains('Produk Milik Admin')
                && ! $products->pluck('name')->contains('Produk Admin Lain');
        });
    }

    private function createProductFor(User $user, string $name): Products
    {
        $categoryId = \DB::table('categories')->insertGetId([
            'name' => 'Kategori Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Products::create([
            'user_id' => $user->id,
            'category_id' => $categoryId,
            'name' => $name,
            'slug' => str($name)->slug(),
            'description' => 'Deskripsi test',
            'price' => 10000,
            'stock' => 10,
            'image' => 'test.jpg',
            'is_visible' => true,
        ]);
    }
}
