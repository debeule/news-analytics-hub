<?php

namespace App\Imports\Dtos;

interface Organization
{
    public function name(): string;
    public function sector(): string;
}