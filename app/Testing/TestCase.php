<?php

declare(strict_types=1);

namespace App\Testing;

use App\Users\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, dispatchesJobs, RefreshDatabase;

    protected $connectionsToTransact = ['db-testing', 'kohera-testing'];

    /**
     * @param object $class
     */
    protected function handle(object $class)
    {
        return $this->app->call([$class, 'handle']);
    }

    /**
     * @param object $class
     */
    protected function dispatch(object $class)
    {
        return $this->app->call([$class, '__invoke']);
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function getApiToken(): string
    {
        $user = User::create();
        $token = $user->createToken('token-name');

        return $token->plainTextToken;
    }
}
