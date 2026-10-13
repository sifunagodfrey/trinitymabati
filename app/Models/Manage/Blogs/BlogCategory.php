<?php

namespace App\Models\Manage\Blogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model
{
    use HasFactory;

    protected $table = 'su_blog_categories';

    protected $guarded = [];

    public $timestamps = false;

    // ---------------
    // Relationships
    // ---------------
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
