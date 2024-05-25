<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityHasOrganization extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'organization_id',
        'author_id',
    ];
    
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
