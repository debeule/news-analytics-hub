<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityHasOccupation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'entity_id',
        'occupation_id',
        'created_at',
    ];
    
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function occupation(): BelongsTo
    {
        return $this->belongsTo(Occupation::class);
    }
}