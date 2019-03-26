<?php

namespace Src\v1\Debug\Application\Listeners;

use Src\v1\Debug\Application\Events\BelajarEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BelajarEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(BelajarEvent $event)
    {
        \Log::info('Ini dari listener : ' . $event->pesan);
    }
}
