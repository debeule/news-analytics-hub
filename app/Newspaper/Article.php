<?php

declare(strict_types=1);

namespace App\Newspaper;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'article_length',
        'full_content',
        'url',
        'is_processed',
        'created_at',
        'category_id',
        'author_id',
        'organization_id'
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