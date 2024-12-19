<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class EjercicioSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()
            ->count(15)
            ->has(Subcategory::factory()->count(5)->has(Product::factory()->count(20)))
            ->create();
    }
}
