<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config("scraping.providers") as $provider) 
        {
            DB::table('organizations')->insert([
                'name' => $provider['name'],
                'organization_type' => $provider['organization_type'],
            ]);
        }
    }
}
