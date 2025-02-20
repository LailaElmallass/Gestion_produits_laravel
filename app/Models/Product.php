<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['intitule', 'prix', 'image', 'cat_id', 'origin', 'created_at', 'updated_at'];

    // Correct relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
}
