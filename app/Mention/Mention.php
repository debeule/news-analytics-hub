<?php

declare(strict_types=1);

namespace App\Article;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $fillable = [
        'content',
        'name',
        'entity_id',
        'article_id',
        'location_id',
    ];
    
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
