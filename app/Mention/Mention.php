<?php

declare(strict_types=1);

namespace App\Mention;

use Illuminate\Database\Eloquent\Model;
use App\Entity\Entity;
use App\Entity\Organization;
use App\Article\Article;

class Mention extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'context',
        'sentiment',
        'entity_id',
        'organization_id',
        'article_id',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
