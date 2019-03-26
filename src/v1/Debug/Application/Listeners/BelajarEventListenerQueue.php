<?php

namespace Src\v1\Debug\Application\Listeners;

use Src\v1\Debug\Application\Events\BelajarEventQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BelajarEventListenerQueue implements ShouldQueue
{
    use InteractsWithQueue;
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
    public function handle(BelajarEventQueue $event)
    {
        \Log::info('Ini dari listener queue : ' . $event->pesan);
    }
}
