<?php

namespace App\Newspaper\Commands;

final class ProcessCategories
{
    public function __construct(
        private collection $categories,
    ) {}

    public function setup(Collection $categories)
    {
        return new self($this->categories = $categories);
    }

    public function execute(): void
    {
        $filteredCategories = $this->DispatchSync(new FilterAdditions(Category::get(), $this->categories));
        
        foreach ($filteredCategories as $category) 
        {
            $this->dispatchSync(new CreateCategory($category));
        }
    }
}