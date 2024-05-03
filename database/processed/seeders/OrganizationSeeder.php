<?php

namespace Database\Db\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'organization_type' => $organization['organization_type'],
            ]);
        }
    }
}
