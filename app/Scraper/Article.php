<?php

declare(strict_types=1);

namespace App\Scraper;

use Illuminate\Database\Eloquent\Model;
use App\Imports\Queries\Article as ArticleInterface;

class Article extends Model implements ArticleInterface
{
    protected $fillable = [
        'title',
        'url',
        'full_content',
        'category',
        'author',
        'organization',
        'article_created_at'
    ];

    protected $casts = [
        'article_created_at' => 'datetime',
    ];

    
    public function getUrl(): string
    {
        return $this->url;
    }

    public function getFullContent(): string
    {
        return $this->full_content;
    }
}
