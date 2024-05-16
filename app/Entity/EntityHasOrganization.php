<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EntityHasOrganization extends Model
{
    protected $fillable = [
        'organization_id',
        'author_id',
    ];
    
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
