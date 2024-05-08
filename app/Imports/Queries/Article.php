<?php

namespace App\Imports;

interface Article 
{
    public function title(): string;
    public function url(): string;
    public function fullContent(): ?string;
    public function organization(): string;
}