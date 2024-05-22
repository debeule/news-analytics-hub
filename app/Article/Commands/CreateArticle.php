<?php

declare(strict_types=1);


namespace App\Article\Commands;

use App\Article\Article as DbArticle;
use App\Imports\Dtos\ProcessedArticle as Article;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Entity\Queries\EntityByName;
use App\Entity\Queries\OrganizationByName;

final class CreateArticle
{
    use DispatchesJobs;

    public function __construct(
        public Article $article,
        private EntityByName $entityByName = new EntityByName(),
        private OrganizationByName $organizationByName = new OrganizationByName(),
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
        
        $newArticle->author_id = $this->entityByName->hasName($article->author())->find()->id ?? null;
        $newArticle->organization_id = $article->organizationId();

        return $newArticle;
    }
}