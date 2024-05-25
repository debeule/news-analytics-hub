<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
    
    public function entityHasOccupations(): HasMany
    {
        return $this->hasMany(EntityHasOccupation::class);
    }
}