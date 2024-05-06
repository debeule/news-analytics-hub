<?php

declare(strict_types=1);

namespace App\Newspaper;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'sector'
    ];
    
    public function entityHasOccupations()
    {
        return $this->hasMany(EntityHasOccupation::class);
    }
}
