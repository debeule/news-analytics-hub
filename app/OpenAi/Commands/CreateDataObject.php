<?php

declare(strict_types=1);

namespace App\OpenAi\Commands;

use App\Imports\Dtos\Article;

use App\OpenAi\Data;

use App\OpenAi\Entity;
use App\OpenAi\Mention;
use App\OpenAi\Occupation;
use App\OpenAi\Organization;
use Illuminate\Support\Collection;

class CreateDataObject
{
    public function __construct(
        private Array $data,
        private Article $article,
    ) {}

    public static function fromArray(array $dataArray, Article $article): self
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
        $this->article->category = $this->data['category'];
        $this->article->created_at = $this->data['created_at'];

        return $this->article;
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
                $entity['occupation'],
                $entity['organization'],
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
                $mention['entityName'],
                $mention['organizationName'],
            ));
        }

        return $mentions;
    }
}