<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Entity\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;

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