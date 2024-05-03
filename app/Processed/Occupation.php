<?php

namespace App\Processed;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
