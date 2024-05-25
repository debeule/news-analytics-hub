<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class RateLimitorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Queue::popUsing('default', function ($connection, $queue) 
        {
            $requestLimits = ['rpm' => 3500, 'rpd' => 10000];
            $timeFrame = ['minute' => now()->format('Y-m-d H:i'), 'day' => now()->format('Y-m-d')];

            $minuteRequests = Cache::get("requests:minute:{$timeFrame['minute']}", 0);
            $dayRequests = Cache::get("requests:day:{$timeFrame['day']}", 0);

            if ($minuteRequests >= $requestLimits['rpm']) return null;
            if ($dayRequests >= $requestLimits['rpd']) return null;

            $job = Queue::getConnection($connection)->pop($queue);

            if ($job) 
            {
                Cache::put("requests:minute:{$timeFrame['minute']}", $minuteRequests + 1, Carbon::now()->addMinute());
                Cache::put("requests:day:{$timeFrame['day']}", $dayRequests + 1, Carbon::now()->addDay());
            }

            return $job;
        });
    }
}