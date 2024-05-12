<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Newspaper\Organization;

final class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'organization_type' => $this->faker->randomElement(['newspaper']),
        ];
    }
}