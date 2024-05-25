<?php

declare(strict_types=1);

namespace App\Imports\Dtos;

use App\Imports\Collections\EntityCollection;
use App\Imports\Collections\MentionCollection;
use App\Imports\Collections\OccupationCollection;
use App\Imports\Collections\OrganizationCollection;

interface Data 
{
    public function article(): ProcessedArticle;
    public function occupations(): OccupationCollection;
    public function organizations(): OrganizationCollection;
    public function entities(): EntityCollection;
    public function mentions(): MentionCollection;
}