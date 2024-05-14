<?php

declare(strict_types=1);

namespace App\Newspaper;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'organization_type'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function entityHasOrganizations()
    {
        return $this->hasMany(EntityHasOrganization::class);
    }
}
