<?php

declare(strict_types=1);

namespace App\Article;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];
}
