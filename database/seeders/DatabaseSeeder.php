<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\db\Seeders\OrganizationSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            OrganizationSeeder::class,
        ]);
    }
}
