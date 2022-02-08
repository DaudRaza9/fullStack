<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogcategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_id',
        'blog_id'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
