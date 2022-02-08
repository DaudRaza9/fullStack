<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogtag extends Model
{
    use HasFactory;
    protected $fillable=[
        'tag_id',
        'blog_id'
    ];

    public function tags()
    {
        return $this->belongsTo(Tag::class);
    }

    public function blogs(){
        return $this->belongsTo(Blog::class);
    }

}
