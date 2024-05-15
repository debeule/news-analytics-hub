<?php 

namespace App\Entity\Commands;

use App\Imports\Dtos\Article;
use App\Article\Article as DbArticle;
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
        $newArticle->url = $article->url();
        $newArticle->organization_id = $article->organizationId();

        return $newArticle;
    }
}