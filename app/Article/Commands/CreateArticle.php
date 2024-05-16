<?php

declare(strict_types=1);


namespace App\Article\Commands;

use App\Article\Article as DbArticle;
use App\Imports\Dtos\Article;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateArticle
{
    use DispatchesJobs;

    public function __construct(
        public Article $article
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->article)->save();
    }   

    private function buildRecord(Article $article): DbArticle
    {
        $newArticle = new DbArticle();
        
        $newArticle->title = $article->title();
        $newArticle->full_content = $article->fullContent();
        $newArticle->url = $article->url();

        $newArticle->category = $article->category();
        $newArticle->word_count = str_word_count($this->article->fullContent());
        $newArticle->article_created_at = $article->createdAt();
        
        $newArticle->author_id = $article->authorId();
        $newArticle->organization_id = $article->organizationId();

        return $newArticle;
    }
}