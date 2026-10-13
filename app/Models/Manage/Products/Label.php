<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
    use HasFactory;

    protected $table = 'su_product_labels';

    protected $guarded = [];
    
    public $timestamps = false;

    protected $fillable = [
        'name',
        'color_code',
        'description'
    ];

    // --------------- Relationships ---------------
    public function products()
    {
        return $this->hasMany(Product::class, 'label_id');
    }
}