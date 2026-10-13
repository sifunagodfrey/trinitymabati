<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'su_product_categories';

    public $timestamps = false;
    protected $guarded = [];

    // ---------------
    // Casts
    // ---------------
    protected $casts = [
        'is_default' => 'boolean',
    ];

    // --------------- Relationships ---------------
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}