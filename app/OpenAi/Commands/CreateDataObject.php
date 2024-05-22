<?php

declare(strict_types=1);

namespace App\OpenAi\Commands;

use App\Imports\Dtos\Article as ArticleInterface;
use App\OpenAi\Article;

use App\OpenAi\Data;

use App\OpenAi\Entity;
use App\OpenAi\Mention;
use App\OpenAi\Occupation;
use App\OpenAi\Organization;
use Illuminate\Support\Collection;

use App\Entity\Organization as DbOrganization;

class CreateDataObject
{
    public function __construct(
        private Array $data,
        private ArticleInterface $article,
    ) {}

    public static function fromArray(array $dataArray, ArticleInterface $article): self
    {
        return new self($dataArray, $article);
    }

    public function toDataObject(): Data
    {
        return new Data(
            $this->collectArticle(),
            $this->collectOccupations(),
            $this->collectOrganizations(),
            $this->collectEntities(),
            $this->collectMentions(),
        );
    }

    private function collectArticle(): Article
    {
        return new Article(
            $this->article->title,
            $this->article->url,
            $this->article->fullContent,
            $this->data['category'],
            $this->article->organizationId,
            $this->data['author'],
            $this->data['created_at'],
        );
    }
    
    private function collectOccupations(): ?collection
    {
        if(is_null($this->data['occupations'])) return null;

        $occupations = collect();
        
        foreach ($this->data['occupations'] as $occupation) 
        {
            $occupations->push(new Occupation(
                $occupation['name'],
                $occupation['sector'],
            ));
        }

        return $occupations;
    }
    
    private function collectOrganizations(): ?collection
    {
        if(is_null($this->data['organizations'])) return null;

        $organizations = collect();

        foreach ($this->data['organizations'] as $organization) 
        {
            $organizations->push(new Organization(
                $organization['name'],
                $organization['sector'],
            ));
        }

        return $organizations;
    }
    
    private function collectEntities(): ?collection
    {
        if(is_null($this->data['entities'])) return null;

        $entities = collect();

        foreach ($this->data['entities'] as $entity) 
        {
            $entities->push(new Entity(
                $entity['name'],
                $entity['occupation'] ?? null,
                $entity['organization'] ?? null,
            ));
        }

        if($this->data['author'] != null)
        {
            $entities->push(new Entity(
                $this->data['author'],
                'author',
                DbOrganization::find($this->article->organizationId())->name,
            ));
        }

        return $entities;
    }
    
    private function collectMentions(): ?collection
    {
        $mentions = collect();

        foreach ($this->data['mentions'] as $mention) 
        {
            $mentions->push(new Mention(
                $mention['context'],
                intval($mention['sentiment']),
                $mention['entityName'] ?? null,
                $mention['organizationName'] ?? null,
            ));
        }

        return $mentions;
    }
}