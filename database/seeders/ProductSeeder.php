<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            ['name' => 'Seller Koperasi', 'password' => bcrypt('password')]
        );

        $products = [
            [
                'user_id' => $seller->id,
                'category_id' => 1,
                'name' => 'Beras Premium 5 Kg',
                'slug' => Str::slug('Beras Premium 5 Kg'),
                'description' => 'Beras premium kualitas terbaik.',
                'price' => 75000,
                'stock' => 100,
                'image' => 'beras.jpg',
                'is_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $seller->id,
                'category_id' => 1,
                'name' => 'Minyak Goreng 2 Liter',
                'slug' => Str::slug('Minyak Goreng 2 Liter'),
                'description' => 'Minyak goreng kemasan 2 liter.',
                'price' => 38000,
                'stock' => 50,
                'image' => 'minyak.jpg',
                'is_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $seller->id,
                'category_id' => 2,
                'name' => 'Mie Instan Goreng',
                'slug' => Str::slug('Mie Instan Goreng'),
                'description' => 'Mie instan rasa goreng.',
                'price' => 3500,
                'stock' => 200,
                'image' => 'mie-instan.jpg',
                'is_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $seller->id,
                'category_id' => 3,
                'name' => 'Teh Botol',
                'slug' => Str::slug('Teh Botol'),
                'description' => 'Minuman teh siap minum.',
                'price' => 5000,
                'stock' => 120,
                'image' => 'teh-botol.jpg',
                'is_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $seller->id,
                'category_id' => 6,
                'name' => 'Pupuk Urea 50 Kg',
                'slug' => Str::slug('Pupuk Urea 50 Kg'),
                'description' => 'Pupuk urea untuk tanaman.',
                'price' => 250000,
                'stock' => 20,
                'image' => 'pupuk-urea.jpg',
                'is_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            Products::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
