<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OccupationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('occupations')->insert([
            'name' => 'author',
            'sector' => 'media',
        ]);
    }
}
