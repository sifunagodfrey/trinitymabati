<?php

namespace App\Models\Frontend;

use App\Models\User;
use App\Models\Manage\Blogs\BlogCategory;
use App\Models\Manage\Blogs\BlogTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'su_blog_posts';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'banner',
        'author_id',
        'category_id',
        'is_published',
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published'  => 'boolean',
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

    // ---------------
    // Scope: published only
    // ---------------
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
