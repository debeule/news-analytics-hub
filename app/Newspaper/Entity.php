<?php

declare(strict_types=1);

namespace App\Newspaper;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'created_at'
    ];
    
    public function entityHasOccupations()
    {
        return $this->hasMany(EntityHasOccupation::class);
    }
}
