<?php

declare(strict_types=1);

namespace App\Article;

use App\Entity\Organization;
use App\Mention\Mention;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function mentions(): HasMany
    {
        return $this->hasMany(Mention::class);
    }
}
