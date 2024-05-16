<?php

declare(strict_types=1);

namespace App\Article;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'word_count',
        'full_content',
        'url',
        'article_created_at',
        'category',
        'author_id',
        'organization_id',
    ];
    
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function mentions()
    {
        return $this->hasMany(Mention::class);
    }
}
