<?php

declare(strict_types=1);

namespace Database\Scraper;

use App\Scraper\Article;
use App\Imports\Values\ProvinceGroup;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;
use Database\Factories\OrganizationFactory;

final class ArticleFactory
{
    private ?int $organizationId = null;

    public function __construct(
        private Collection $articles,
    ){}

    public static function new()
    {
        return new self(collect());
    }

    public function withOrganizationId(int $organizationId): self
    {
        $this->organizationId = $organizationId;

        return $this;
    }

    public static function build(int $organizationId = null): Article
    {
        $faker = FakerFactory::create();

        return new Article(
            $faker->text(10),
            $faker->url(),
            $organizationId ?? OrganizationFactory::new()->create()->id,
            $faker->randomHtml(),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->articles->push($this->build($this->organizationId));
        }

        return new self($this->articles);
        
    }

    public function create()
    {
        if($this->articles->count() === 1) 
        {
            if ($this->organizationId !== null) 
            {
                #TODO: setting org id not needed with changes in build method?
                $this->articles->first()->organization_id = $this->organizationId;
            }

            return $article;
        }

        if ($this->organizationId !== null) 
        {
            foreach ($this->articles as $article) 
            {
                $article->organization_id = $this->organizationId;
            }
        }

        return $this->articles;
    }
}