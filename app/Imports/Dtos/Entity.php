<?php

namespace App\Imports\Dtos;

interface Entity     
{
    public function name(): string;
    public function occupation(): string;
    public function organization(): string;
}