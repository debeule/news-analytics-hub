<?php

declare(strict_types=1);

namespace App\Imports\Dtos;

use App\Imports\Queries\Collections\EntityCollection;
use App\Imports\Queries\Collections\MentionCollection;
use App\Imports\Queries\Collections\OccupationCollection;
use App\Imports\Queries\Collections\OrganizationCollection;

interface Data 
{
    public function article(): Article;
    public function occupations(): OccupationCollection;
    public function organizations(): OrganizationCollection;
    public function entities(): EntityCollection;
    public function mentions(): MentionCollection;
}