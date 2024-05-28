<?php

declare(strict_types=1);


namespace App\Mention\Commands;

use App\Imports\Dtos\Mention;
use App\Imports\Values\DateTime;
use App\Mention\Mention as DbMention;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateMention
{
    use DispatchesJobs;

    public function __construct(
        public Mention $mention,
        private int $articleId,
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->mention)->save();
    }   

    private function buildRecord(Mention $mention): DbMention
    {
        $newMention = new DbMention();
        
        $newMention->context = $mention->context();

        $newMention->sentiment = $mention->sentiment();
        $newMention->mention_created_at = DateTime::now()->toString();
        
        $newMention->entity_id = $mention->entity()->id ?? null;
        $newMention->organization_id = $mention->organization()->id ?? null;
        $newMention->article_id = $this->articleId;

        return $newMention;
    }
}