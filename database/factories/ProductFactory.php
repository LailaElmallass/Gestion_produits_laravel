<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'intitule' => $this->faker->word(), // Génère un mot aléatoire pour l'intitulé
            'prix' => $this->faker->randomFloat(2, 1, 100), // Génère un prix aléatoire entre 1 et 100
            'image' => $this->faker->imageUrl(), // Changez 'photo' par 'image'
            'cat_id' => Category::factory(), // Associe un produit à une catégorie existante ou nouvelle
        ];
    }
}

