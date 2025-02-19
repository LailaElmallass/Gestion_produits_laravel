<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Créer 10 catégories factices
        Category::factory(10)->create();

        // Créer 50 produits factices avec des catégories associées
        Product::factory(50)->create();
    }
}
