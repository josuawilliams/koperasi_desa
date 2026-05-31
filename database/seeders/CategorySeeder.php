<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryName = [
            "Fashion Pria",
            "Minuman",
            "Peralatan Rumah Tangga",
            "Mainan",
            "Olahraga",
            "Komputer & Laptop"
        ];

        foreach ($categoryName as $c) {
            Categories::firstOrCreate(
                ['name' => $c]
            );
        };
    }
}
