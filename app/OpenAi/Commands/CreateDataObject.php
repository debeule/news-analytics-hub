<?php

declare(strict_types=1);

namespace App\OpenAi\Commands;

use App\Entity\Organization as DbOrganization;
use App\Imports\Dtos\Article as ArticleInterface;

use App\OpenAi\Article;

use App\OpenAi\Data;
use App\OpenAi\Entity;
use App\OpenAi\Mention;
use App\OpenAi\Occupation;
use App\OpenAi\Organization;

use Illuminate\Support\Collection;

use App\Imports\Collections\EntityCollection;
use App\Imports\Collections\MentionCollection;
use App\Imports\Collections\OccupationCollection;
use App\Imports\Collections\OrganizationCollection;

class CreateDataObject
{
    public function __construct(
        /** @var array<mixed> */
        private Array $data,
        
        private ArticleInterface $article,
    ) {}

    
    /** @param array<mixed> $dataArray */
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
            $this->article->title(),
            $this->article->url(),
            $this->article->fullContent(),
            $this->article->organizationId(),
            $this->data['category'],
            $this->data['author'],
            $this->data['created_at'],
        );
    }
    
    private function collectOccupations(): ?OccupationCollection
    {
        if(is_null($this->data['occupations'])) return null;

        $occupations = new OccupationCollection;
        
        foreach ($this->data['occupations'] as $occupation) 
        {   
            $occupations->push(new Occupation(
                $occupation['name'],
                $occupation['sector'],
            ));
        }

        return $occupations;
    }
    
    private function collectOrganizations(): ?OrganizationCollection
    {
        if(is_null($this->data['organizations'])) return null;

        $organizations = new OrganizationCollection;

        foreach ($this->data['organizations'] as $organization) 
        {
            $organizations->push(new Organization(
                $organization['name'],
                $organization['sector'],
            ));
        }

        return $organizations;
    }
    
    private function collectEntities(): ?EntityCollection
    {
        if(is_null($this->data['entities'])) return null;

        $entities = new EntityCollection;

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
    
    private function collectMentions(): Mentioncollection
    {
        $mentions =  new MentionCollection;

        foreach ($this->data['entity-mentions'] as $mention) 
        {
            $mentions->push(new Mention(
                $mention['context'],
                intval($mention['sentiment']),
                $mention['entityName'] ?? null,
                $mention['organizationName'] ?? null,
            ));
        }

        foreach ($this->data['organization-mentions'] as $mention) 
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