<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeArticlesListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $organizationId)
    {}

    public function handle(): void
    {
        $changeDirCommand = "cd " . config("scraping.destination");
        $enableVenvCommand = "source ./venv/Scripts/activate";

        $scrapyCommand = 'scrapy crawl ArticleListScraper -a organization_id=' . $this->organizationId;

        $combinedCommand = $changeDirCommand . " && " . $enableVenvCommand . " && " . $scrapyCommand;
        
        try 
        {
            shell_exec($combinedCommand);
        } 
        catch (\Exception $e) 
        {
            DB::table('logs')->insert([
                'log_level' => 'error',
                'message' => $e->getMessage(),
                'failed_action' => $combinedCommand,
            ]);
        }
    }
}
