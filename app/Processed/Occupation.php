<?php

declare(strict_types=1);

namespace App\Processed;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'main_title',
        'url',
        'full_content',
        'category',
        'author',
        'organization',
        'article_created_at',
    ];
}
