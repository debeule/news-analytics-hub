<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Article\Article;
use App\Location\Location;

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

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function entityHasOrganizations(): HasMany
    {
        return $this->hasMany(EntityHasOrganization::class);
    }
}
