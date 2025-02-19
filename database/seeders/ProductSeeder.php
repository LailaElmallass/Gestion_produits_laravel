<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  // database/seeders/ProductSeeder.php

  public function run()
  {
    DB::table('products')->insert([
        [
            'intitule' => 'Product Name',
            'prix' => 10.99,
            'image' => 'https://via.placeholder.com/640x480.png',
            'cat_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Add more products as needed
    ]);
    
    
    
  }
  



}
