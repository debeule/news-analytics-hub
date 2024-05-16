<?php

declare(strict_types=1);

namespace App\Imports\Dtos;

use App\Entity\Entity;
use App\Entity\Organization;
use App\Article\Article;

interface Mention 
{
    public function context(): string;
    public function sentiment(): int;
    public function entity(): Entity;
    public function organization(): Organization;
}