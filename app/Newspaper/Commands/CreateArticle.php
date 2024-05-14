<?php 

namespace App\Newspaper\Commands;

use App\Imports\Queries\Article;
use App\Newspaper\Article as DbArticle;
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
        $newArticle->article_created_at = $article->createdAt();
        $newArticle->organization_id = $article->organizationId();

        return $newArticle;
    }
}