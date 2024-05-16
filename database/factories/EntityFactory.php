<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Entity\Entity;

final class EntityFactory extends Factory
{
    protected $model = Entity::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}