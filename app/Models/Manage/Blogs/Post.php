<?php

namespace App\Models\Manage\Blogs;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'su_blog_posts';

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];
    // ---------------
    // Relationships
    // ---------------
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'su_post_tag', 'post_id', 'tag_id');
    }
}

