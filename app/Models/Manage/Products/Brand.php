<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'su_brands';

    protected $guarded = [];

    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug', 
        'description',
        'logo',
        'banner_image'
    ];

    // --------------- Relationships ---------------
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}