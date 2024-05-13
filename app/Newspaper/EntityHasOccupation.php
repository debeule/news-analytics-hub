<?php

declare(strict_types=1);

namespace App\Newspaper;

use Illuminate\Database\Eloquent\Model;

class EntityHasOccupation extends Model
{
    protected $fillable = [
        'entity_id',
        'occupation_id',
        'created_at'
    ];
    
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }
}