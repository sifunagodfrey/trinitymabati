<?php

namespace App\Models\Manage\Blogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogTag extends Model
{
    use HasFactory;

    protected $table = 'su_blog_tags';

    protected $guarded = [];

    public $timestamps = false;
    // ---------------
    // Relationships
    // ---------------
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'su_post_tag', 'tag_id', 'post_id');
    }
}
