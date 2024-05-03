<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\db\Seeders\OrganizationSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            OrganizationSeeder::class,
        ]);
    }
}
