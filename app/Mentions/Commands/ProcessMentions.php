<?php

namespace App\Newspaper\Commands;

final class ProcessMentions
{
    public function __construct(
        private collection $mentions,
    ) {}

    public function setup(Collection $mentions)
    {
        return new self($this->mentions = $mentions);
    }

    public function execute(): void
    {
        $filteredCategories = $this->DispatchSync(new FilterAdditions(Mention::get(), $this->mention));
        
        foreach ($filteredCategories as $mention) 
        {
            $this->dispatchSync(new CreateCategory($mention));
        }
    }
}