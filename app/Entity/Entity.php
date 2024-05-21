<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
    
    public function entityHasOccupations()
    {
        return $this->hasMany(EntityHasOccupation::class);
    }
}