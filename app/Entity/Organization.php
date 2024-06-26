<?php

declare(strict_types=1);

namespace App\Entity;

use App\Article\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'sector',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function entityHasOrganizations(): HasMany
    {
        return $this->hasMany(EntityHasOrganization::class);
    }
}
