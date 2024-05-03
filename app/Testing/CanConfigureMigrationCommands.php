<?php

declare(strict_types=1);

namespace App\Testing;

use Illuminate\Foundation\Testing\Traits\CanConfigureMigrationCommands as BaseCanConfigureMigrationCommands;

trait CanConfigureMigrationCommands
{
    use BaseCanConfigureMigrationCommands;
    
    protected function customMigrateFreshUsing()
    {
        $seeder = $this->seeder();

        return array_merge(
            [
                '--drop-views' => $this->shouldDropViews(),
                '--drop-types' => $this->shouldDropTypes(),
                '--path' => 'database/main/migrations/',
            ],
            $seeder ? ['--seeder' => $seeder] : ['--seed' => $this->shouldSeed()]
        );
    }
}
