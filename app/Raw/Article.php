<?php

declare(strict_types=1);

namespace App\Raw;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'main_title',
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
}
