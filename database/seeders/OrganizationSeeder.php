<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config("scraping.organizations") as $organization) 
        {
            DB::table('organizations')->insert([
                'name' => $organization['name'],
                'type' => $organization['type'],
            ]);
        }
    }
}
