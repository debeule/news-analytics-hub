<?php

namespace App\Newspaper\Commands;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\OpenAi\Commands\ProcessData;
use App\Imports\Queries\Article as ExternalArticle;
use App\Article\Commands\ProcessArticleDomain;

final class ProcessArticle implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public ExternalArticle $article,
        private ArticleByTitle $articleByTitle = new ArticleByTitle(),
    ){}

    public function __invoke(): void
    {
        $data = ProcessData::setup($this->article->fullContent)->execute();

        $this->article->article_created_at = $data['created_at'];
        $this->article->category = $data['category'];

        $this->dispatchSync(new ProcessArticleDomain($this->article));

        $article = $this->articleByTitle->hasTitle($this->article->title)->find();
        
        $this->dispatchSync(new ProcessEntityDomain($data, $article->id));
        $this->dispatchSync(new ProcessMentionDomain($data, $article->id));
    }
}