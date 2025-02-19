<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// In database/seeders/CategorySeeder.php

use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Create 10 categories
        $categories = [
            'Electronics',
            'Furniture',
            'Clothing',
            'Toys',
            'Books',
            'Food',
            'Health & Beauty',
            'Sports',
            'Automotive',
            'Home Appliances'
        ];

        foreach ($categories as $category) {
            Category::create([
                'intitule' => $category
            ]);
        }
    }
}
