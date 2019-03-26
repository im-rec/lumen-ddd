<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Src\v1\Debug\Application\Events\BelajarEvent' => [
            'Src\v1\Debug\Application\Listeners\BelajarEventListener',
        ],
        'Src\v1\Debug\Application\Events\BelajarEventQueue' => [
            'Src\v1\Debug\Application\Listeners\BelajarEventListenerQueue',
        ],
    ];
}
