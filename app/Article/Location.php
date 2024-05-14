<?php

declare(strict_types=1);

namespace App\Newspaper;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'country',
        'city',
        'street',
        'organization_id'
    ];
    
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function mentions()
    {
        return $this->hasMany(Mention::class);
    }
}
