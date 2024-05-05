<?php

namespace App\Imports;

interface Article 
{
    public function getMainTitle(): string;
    public function getUrl(): string;
    public function getFullContent(): string;
    public function getCategory(): string;
    public function getAuthor(): string;
    public function getOrganization(): string;
    public function getArticleCreatedAt(): \DateTime;
}