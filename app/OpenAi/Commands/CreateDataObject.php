<?php

namespace App\OpenAi\Commands;

use Illuminate\Support\Collection;

use App\Imports\Dtos\Article;

use App\OpenAi\Organization;
use App\OpenAi\Occupation;
use App\OpenAi\Mention;
use App\OpenAi\Entity;
use App\OpenAi\Data;

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
    
    private function collectOccupations(): collection
    {
        $occupations = collect();
        
        foreach ($this->data['occupations'] as $occupation) 
        {
            $occupations->push(new Occupation($occupation));
        }

        return $occupations;
    }
    
    private function collectOrganizations(): collection
    {
        $organizations = collect();

        foreach ($this->data['organizations'] as $organization) 
        {
            $organizations->push(new Organization($organization));
        }

        return $organizations;
    }
    
    private function collectEntities(): collection
    {
        $entities = collect();

        foreach ($this->data['entities'] as $entity) 
        {
            $entities->push(new Entity($entity));
        }

        return $entities;
    }
    
    private function collectMentions(): collection
    {
        $mentions = collect();

        foreach ($this->data['mentions'] as $mention) 
        {
            $mentions->push(new Mention($mention));
        }

        return $mentions;
    }
}