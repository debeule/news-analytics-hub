<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Entity\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(['source_newspaper']),
        ];
    }
}